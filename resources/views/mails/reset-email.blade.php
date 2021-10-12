<!DOCTYPE html>
<html>
<head>
    <title>Page Title</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">
    <link rel="stylesheet" href="/assets/auth/style.css" type="text/css">
</head>
<body>

<h1>{{$details['title']}}</h1>
<p>{{$details['text']}}</p><br>

<a href="{{$details['link']}}" target="_blank"><button class="red-btn">{{$details['link_text']}}</button></a>
<p>Thanks</p>

</body>
</html>
