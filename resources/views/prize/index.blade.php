<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>抽奖</title>
    <script src="/jquery-3.3.1.min.js"></script>
</head>
<body>
    <button id="btn">抽奖</button>
</body>
</html>
<script>
    $(document).on('click','#btn',function(){
        $.ajax({
            url:'/prize/prizedo',
            type:'post',
            dataType:'json',
            success:function(res){
                if(res.error != 0){
                    alert(123);
                }else{
                    alert(res.msg);
                }
            }
        })
    })
</script>