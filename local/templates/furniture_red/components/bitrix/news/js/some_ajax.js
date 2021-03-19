function ajax_request(path,newsID){
    $.ajax({
        url: path+"?news_id="+ newsID +"&ajax=Y",
        success: function(data){
            $('#hidden_answ').html(data).show();
        }
    });
}
console.log(33);