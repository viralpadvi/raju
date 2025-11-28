<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Export</title>
  <style>
    body { font-family: Arial, sans-serif; font-size: 12px; color: #111; margin: 20px; }
    h2 { margin-bottom: 10px; }
    table { width: 100%; border-collapse: collapse; }
    th, td { padding: 8px 10px; border: 1px solid #ddd; text-align: left; }
    th { background-color: #14b8a6; color: #fff; text-transform: uppercase; font-size: 11px; letter-spacing: .5px; }
    tr:nth-child(even) td { background-color: #f8fafc; }
  </style>
</head>
<body>
  <h2>A R Electronics &mdash; Export Report</h2>
  <table>
    <thead>
      <tr>
        @foreach($headers as $header)
          <th>{{ $header }}</th>
        @endforeach
      </tr>
    </thead>
    <tbody>
      @foreach($data as $row)
        <tr>
          @foreach($row as $cell)
            <td>{{ $cell }}</td>
          @endforeach
        </tr>
      @endforeach
    </tbody>
  </table>
</body>
</html>


