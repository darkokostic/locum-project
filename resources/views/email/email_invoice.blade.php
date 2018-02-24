<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <meta charset="utf-8">
    <title>Locum Invoice</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>

    <link rel="stylesheet" href="style.css" media="all"/>
<style>
   
</style>
</head>
<body>
    <div class="container">
        <p>Dear, </p>
        @if(sizeof($jobs) > 1)
        <p>Please find attached a copy of the Invoice for my service delivered for {{date('F', strtotime($jobs[0]->job_start))}}</p>
        <p>Please send payment as agreed in Practice, if you have any question please do not hesitate to contact me.</p>
        <p>Thank you,</p>
        <p>{{$user->name}}</p>
        @else
        <p>Please find attached a copy of the Invoice for my service delivered between {{date('d/m', strtotime($jobs[0]->job_start))}} to {{date('d/m', strtotime($jobs[0]->job_end))}}</p>
        <p>Please send payment as agreed in Practice, if you have any question please do not hesitate to contact me.</p>
        <p>Thank you,</p>
        <p>{{$user->name}}</p>
        @endif
    </div>
</body>
</html>