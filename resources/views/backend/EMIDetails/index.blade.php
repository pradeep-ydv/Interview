<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Process EMI Data</title>
</head>

<body>

    <div style="display: flex; flex-direction: column; justify-content: center; align-items: center; height: 100vh;">
        <h1 style="margin-bottom: 20px;">Process EMI Data</h1>
        <form action="{{ route('emi_details.process') }}" method="POST">
            @csrf
            <button type="submit"
                style="padding: 10px 20px; background-color: #4CAF50; color: white; border: none; border-radius: 4px; cursor: pointer;">Process
                Data</button>
        </form>
    </div>
</body>

</html>
