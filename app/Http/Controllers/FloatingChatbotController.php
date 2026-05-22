<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Store;
use App\Models\Sale;
use App\Models\Manufacturer;
use Illuminate\Support\Facades\Cache;

class FloatingChatbotController extends Controller
{
    public function sendMessage(Request $request)
    {
        $request->validate([
            'message' => 'required|string|max:500'
        ]);

        $userMessage = $request->message;
        
        // Get conversation history from session
        $conversation = session()->get('floating_chat_conversation', []);
        
        // Add user message to history
        $conversation[] = ['role' => 'user', 'content' => $userMessage];
        
        // Get response based on message
        $botReply = $this->getSmartResponse($userMessage);
        
        // Add bot response to history
        $conversation[] = ['role' => 'assistant', 'content' => $botReply];
        
        // Keep only last 10 messages
        if (count($conversation) > 10) {
            $conversation = array_slice($conversation, -10);
        }
        
        session()->put('floating_chat_conversation', $conversation);
        
        return response()->json([
            'success' => true,
            'reply' => $botReply,
            'conversation' => $conversation
        ]);
    }
    
    private function getSmartResponse($message)
    {
        $message = strtolower($message);
        
        // Product queries
        if (str_contains($message, 'product') || str_contains($message, 'stock') || str_contains($message, 'item')) {
            $count = Product::count();
            $products = Product::with('manufacturer')->take(5)->get();
            
            if ($products->isEmpty()) {
                return "We're currently adding products to our system. Please check back soon!";
            }
            
            $productList = "";
            foreach ($products as $product) {
                $productList .= "\n• {$product->name}";
                if ($product->price) {
                    $productList .= " (R" . number_format($product->price, 2) . ")";
                }
            }
            
            return "We have {$count} products available. Here are some examples:{$productList}\n\nWhat specific product are you looking for?";
        }
        
        // Specific product search
        foreach (Product::all() as $product) {
            if (str_contains($message, strtolower($product->name))) {
                $response = "**{$product->name}**\n";
                $response .= "💰 Price: R" . number_format($product->price, 2) . "\n";
                $response .= "🏭 Manufacturer: " . ($product->manufacturer->name ?? 'N/A') . "\n";
                if ($product->expiry_date) {
                    $response .= "📅 Expiry: " . date('M j, Y', strtotime($product->expiry_date)) . "\n";
                }
                return $response;
            }
        }
        
        // Store queries
        if (str_contains($message, 'store') || str_contains($message, 'shop') || str_contains($message, 'location')) {
            $count = Store::count();
            $stores = Store::take(5)->get();
            
            if ($stores->isEmpty()) {
                return "We have store locations across the area. Please contact us for specific locations.";
            }
            
            $storeList = "";
            foreach ($stores as $store) {
                $storeList .= "\n• {$store->name} - {$store->location}";
                if ($store->owner_name) {
                    $storeList .= " (Owner: {$store->owner_name})";
                }
            }
            
            return "We have {$count} store locations:{$storeList}\n\nWhich location would you like to visit?";
        }
        
        // Price queries
        if (str_contains($message, 'price') || str_contains($message, 'cost') || str_contains($message, 'how much')) {
            return "Prices vary by product. You can:\n• Browse our products in the Products section\n• Ask me about a specific product\n• Contact your nearest store for current pricing\n\nWhat product are you interested in?";
        }
        
        // Manufacturer/Brand queries
        if (str_contains($message, 'manufacturer') || str_contains($message, 'brand') || str_contains($message, 'make')) {
            $manufacturers = Manufacturer::take(5)->get();
            if ($manufacturers->isNotEmpty()) {
                $list = $manufacturers->pluck('name')->implode(', ');
                return "We work with quality manufacturers including: {$list}. Would you like to know about a specific brand's products?";
            }
            return "We partner with trusted manufacturers to bring you quality products.";
        }
        
        // Sales/Revenue queries
        if (str_contains($message, 'sale') || str_contains($message, 'revenue') || str_contains($message, 'earn')) {
            $todaySales = Sale::whereDate('sale_date', today())->sum('total_amount');
            $monthSales = Sale::whereMonth('sale_date', now()->month)->sum('total_amount');
            
            return "📊 Sales Overview:\n• Today: R" . number_format($todaySales, 2) . "\n• This Month: R" . number_format($monthSales, 2) . "\n\nNeed more detailed sales information? Check the Sales Dashboard!";
        }
        
        // Help queries
        if (str_contains($message, 'help') || str_contains($message, 'what can you do') || str_contains($message, 'capabilities')) {
            return "🤖 I can help you with:\n\n📦 **Products** - Browse, search, and get product details\n🏪 **Stores** - Find store locations and information\n💰 **Pricing** - Check product prices\n🏭 **Brands** - Learn about manufacturers\n📊 **Sales** - Get sales overview\n\nWhat would you like to know?";
        }
        
        // Greetings
        if (str_contains($message, 'hello') || str_contains($message, 'hi') || str_contains($message, 'hey')) {
            return "👋 Hello! Welcome to Spaza Shop Assistant. How can I help you today?\n\nYou can ask me about:\n• Products and prices\n• Store locations\n• Brands and manufacturers\n• Sales information\n\nWhat would you like to know?";
        }
        
        // Thank you
        if (str_contains($message, 'thank')) {
            return "You're welcome! 😊 Is there anything else I can help you with?";
        }
        
        // Goodbye
        if (str_contains($message, 'bye') || str_contains($message, 'goodbye')) {
            return "Thank you for chatting! Have a great day! 👋 Feel free to come back if you have more questions.";
        }
        
        // Default response
        return "Thank you for your question! I'm here to help with:\n• Product information\n• Store locations\n• Pricing\n• Brand inquiries\n\nCould you please provide more details so I can assist you better?";
    }
    
    public function clearConversation()
    {
        session()->forget('floating_chat_conversation');
        return response()->json(['success' => true]);
    }
    
    public function getUnreadCount()
    {
        $conversation = session()->get('floating_chat_conversation', []);
        $unreadCount = 0;
        
        foreach ($conversation as $msg) {
            if ($msg['role'] === 'assistant' && !isset($msg['read'])) {
                $unreadCount++;
            }
        }
        
        return response()->json(['unread_count' => $unreadCount]);
    }
}