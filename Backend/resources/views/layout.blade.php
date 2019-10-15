<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <style>

    body {
        text-align: center;
        background: #f1f1f1;
    }

    .wrapper {
        padding-top:60px;
    }

    .form-control{
        background: #f7f7f7 none repeat scroll 0 0;
        border-color: #ccc;
        box-shadow: 0 1px 0 #ccc;
        color: #555;
        vertical-align: top;
        border-radius: 3px;
        border-style: solid;
        border-width: 1px;
        box-sizing: border-box;
        cursor: pointer;
        display: inline-block;
        font-size: 13px;
        line-height: 26px;
        margin: 0;
        padding: 0 10px 1px;
        text-decoration: none;
        white-space: nowrap;
    }
    button{
        max-width: 200px;
    }

    input.form-control {
        background-color: #fff;
        border: 1px solid #ddd;
        box-shadow: 0 1px 2px rgba(0, 0, 0, 0.07) inset;
        color: #32373c;
        outline: 0 none;
        transition: border-color 50ms ease-in-out 0s;
        margin: 1px;
        padding: 5px 10px;
        border-radius: 0;
        font-size: 14px;
        font-family: inherit;
        font-weight: inherit;
        box-sizing: border-box;
        color: #444;
        font-family: "Open Sans",sans-serif;
        line-height: 1.4em;
        width: 310px;
    }
    *{
        margin:5px;
    }

</style>

</head>
<body>
    <h1>Key Generator App</h1>

        @yield('content')


    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script>
        // Function to produce UUID.
        function generateUUID()
        {
            var d = new Date().getTime();

            if( window.performance && typeof window.performance.now === "function" )
            {
                d += performance.now();
            }

            var uuid = 'xxxxxxxx-xxxx-xxxx-yxxx-xxxxxxxxxxxx'.replace(/[xy]/g, function(c)
            {
                var r = (d + Math.random()*16)%16 | 0;
                d = Math.floor(d/16);
                return (c=='x' ? r : (r&0x3|0x8)).toString(16);
            });

            return uuid;
        }

        // Generate new key and insert into input value
        $( '#keygen' ).on('click',function()
        {
            $( '#apikey' ).val( generateUUID() );
        });
    </script>
</body>
</html>
