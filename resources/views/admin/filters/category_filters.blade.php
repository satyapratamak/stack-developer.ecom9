<?php 
use App\Models\ProductFilters;
$productFilters = ProductFilters::productFilters();

if(isset($product['category_id'])){
    $category_id = $product['category_id'];
}
?>
@foreach ($productFilters as $filter) 
@if(isset($category_id))
<?php 
    $filterAvailable = ProductFilters::filterAvailable($filter['id'], $category_id);
?>
    @if($filterAvailable)
        
        <div class="form-group">
            <label for="{{ $filter['filter_column'] }}">Select {{ $filter['filter_name'] }}</label>
            <select name="{{ $filter['filter_column'] }}" id="{{ $filter['filter_column'] }}" class="form-control text-dark">
                <option value="">-- Select --</option>
                @foreach ($filter['filter_values'] as $value)
                <option value="{{ $value['filter_value']}}"
                @if(!empty($product[$filter['filter_column']]) &&  $product[$filter['filter_column']] == $value['filter_value'])
                selected=""
                @endif
                > {{ ucwords($value['filter_value'])}}</option>            
                @endforeach
            </select>                      
        </div>
        
    @endif
@endif
@endforeach