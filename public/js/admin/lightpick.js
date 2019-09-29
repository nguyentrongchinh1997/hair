    /*Lightpick*/
$(function(){
    var picker = new Lightpick({
        field: document.getElementById('demo-2'),
        singleDate: false,
        onSelect: function(start, end){
            var str = '';
            str += start ? start.format('Do MMMM YYYY') + ' to ' : '';
            str += end ? end.format('Do MMMM YYYY') : '...';
            // document.getElementById('result-2').innerHTML = str;
        }
    }); 
})

/*end*/