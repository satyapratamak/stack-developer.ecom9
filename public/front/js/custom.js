function get_filters(class_name){
    var filter = [];
    $('.'+class_name+":checked").each(function(){
        filter.push($(this).val());
    });

    return filter;
}