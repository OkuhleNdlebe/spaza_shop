<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use OpenAI\Laravel\Facades\OpenAI;
use App\Models\Product;
use App\Models\Store;
use App\Models\Sale;
use Illuminate\Support\Facades\Cache;

class ChatbotController extends Controller
{
    public function index()
    {
        return view('chatbot.index');
    }

    public function sendMessage(Request $request)
    {
        $request->validate([
            'message' => 'required|string|max:500'
        ]);

        $userMessage = $request->message;
        
        // Get conversation history from session
        $conversation = session()->get('chatbot_conversation', []);
        
        // Add user message to history
        $conversation[] = ['role' => 'user', 'content' => $userMessage];
        
        // Check if query is about products, stores, or sales
        $context = $this->getBusinessContext($userMessage);
        
        try {
            // Build system prompt with business context
            $systemPrompt = $this->buildSystemPrompt($context);
            
            // Call OpenAI API
            $response = OpenAI::chat()->create([
                'model' => 'gpt-3.5-turbo',
                'messages' => array_merge(
                    [['role' => 'system', 'content' => $systemPrompt]],
                    $conversation
                ),
                'max_tokens' => 300,
                'temperature' => 0.7
            ]);
            
            $botReply = $response->choices[0]->message->content;
            
            // Add bot response to history
            $conversation[] = ['role' => 'assistant', 'content' => $botReply];
            
            // Keep only last 10 messages
            if (count($conversation) > 10) {
                $conversation = array_slice($conversation, -10);
            }
            
            session()->put('chatbot_conversation', $conversation);
            
            return response()->json([
                'success' => true,
                'reply' => $botReply,
                'conversation' => $conversation
            ]);
            
        } catch (\Exception $e) {
            \Log::error('Chatbot error: ' . $e->getMessage());
            
            // Fallback to local responses
            $fallbackReply = $this->getLocalResponse($userMessage);
            
            return response()->json([
                'success' => true,
                'reply' => $fallbackReply,
                'conversation' => $conversation
            ]);
        }
    }
    
    private function getBusinessContext($query)
    {
        $context = [];
        
        // Check if query asks about products
        if (str_contains(strtolower($query), 'product') || 
            str_contains(strtolower($query), 'item') ||
            str_contains(strtolower($query), 'stock')) {
            $context['products'] = Product::with('manufacturer')->take(5)->get();
            $context['total_products'] = Product::count();
        }
        
        // Check if query asks about stores
        if (str_contains(strtolower($query), 'store') || 
            str_contains(strtolower($query), 'location')) {
            $context['stores'] = Store::take(5)->get();
            $context['total_stores'] = Store::count();
        }
        
        // Check if query asks about sales
        if (str_contains(strtolower($query), 'sale') || 
            str_contains(strtolower($query), 'revenue') ||
            str_contains(strtolower($query), 'earn')) {
            $context['today_sales'] = Sale::whereDate('sale_date', today())->sum('total_amount');
            $context['month_sales'] = Sale::whereMonth('sale_date', now()->month)->sum('total_amount');
        }
        
        return $context;
    }
    
    private function buildSystemPrompt($context)
    {
        $prompt = "You are a helpful customer service assistant for Spaza Shop Management System. ";
        $prompt .= "You help customers find products, check store locations, and answer questions about inventory. ";
        $prompt .= "Keep responses friendly, concise, and helpful. ";
        $prompt .= "If you don't know something, politely say you'll find out or suggest contacting support. ";
        
        if (!empty($context)) {
            $prompt .= "\n\nBusiness Information:\n";
            
            if (isset($context['products'])) {
                $prompt .= "Products available: " . $context['products']->pluck('name')->implode(', ') . "\n";
                $prompt .= "Total products: " . $context['total_products'] . "\n";
            }
            
            if (isset($context['stores'])) {
                $prompt .= "Store locations: " . $context['stores']->pluck('location')->implode(', ') . "\n";
                $prompt .= "Total stores: " . $context['total_stores'] . "\n";
            }
            
            if (isset($context['today_sales'])) {
                $prompt .= "Today's sales: R" . number_format($context['today_sales'], 2) . "\n";
                $prompt .= "Monthly sales: R" . number_format($context['month_sales'], 2) . "\n";
            }
        }
        
        return $prompt;
    }
    
    private function getLocalResponse($query)
    {
        $query = strtolower($query);
        
        // Local fallback responses
        if (str_contains($query, 'hello') || str_contains($query, 'hi')) {
            return "Hello! Welcome to Spaza Shop. How can I help you today?";
        }
        
        if (str_contains($query, 'product') || str_contains($query, 'stock')) {
            $productCount = Product::count();
            return "We have {$productCount} products available in our system. What specific product are you looking for?";
        }
        
        if (str_contains($query, 'store') || str_contains($query, 'location')) {
            $storeCount = Store::count();
            return "We have {$storeCount} store locations. Which area are you interested in?";
        }
        
        if (str_contains($query, 'price')) {
            return "Product prices vary. Could you tell me which product you're interested in?";
        }
        
        if (str_contains($query, 'help')) {
            return "I can help you with:\n- Finding products\n- Store locations\n- Pricing information\n- Stock availability\nJust ask me anything!";
        }
        
        return "Thank you for your question. Could you please provide more details so I can better assist you?";
    }
    
    public function clearConversation()
    {
        session()->forget('chatbot_conversation');
        return redirect()->route('chatbot.index')->with('success', 'Conversation cleared!');
    }
}