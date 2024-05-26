<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EMI Details</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        h1 {
            text-align: center;
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin: 0 auto;
        }

        th,
        td {
            padding: 10px;
            text-align: left;
            border: 1px solid #ddd;
        }

        th {
            background-color: #f2f2f2;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        tr:hover {
            background-color: #ddd;
        }
    </style>
</head>

<body>
    <h1>EMI Details</h1>
    <table>
        <thead>
            <tr>
                <th>Client ID</th>
                @foreach ($emiDetails[0] as $key => $value)
                    @if ($key != 'clientid')
                        <th>{{ $key }}</th>
                    @endif
                @endforeach
            </tr>
        </thead>
        <tbody>
            @foreach ($emiDetails as $detail)
                <tr>
                    <td>{{ $detail->clientid }}</td>
                    @foreach ($detail as $key => $value)
                        @if ($key != 'clientid')
                            <td>{{ number_format($value, 2) }}</td>
                        @endif
                    @endforeach
                </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>
