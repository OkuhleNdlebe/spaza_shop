<div class="mb-3">
    <label for="low_stock_threshold" class="form-label">Low Stock Alert Threshold</label>
    <input type="number" name="low_stock_threshold" class="form-control" 
           value="{{ old('low_stock_threshold', $store->low_stock_threshold) }}" min="1">
    <div class="form-text">Get alerted when product quantity falls below this number</div>
</div>