<!DOCTYPE html>
<html>
<head>
 <meta charset="utf-8">
 <title>Todo List</title>
<link rel="stylesheet" href="/css/style.css">
</head>
<body>
<h2>Atte</h2>
　<ul>
  　<li>ホーム</li>
  　<li>日付一覧</li>
  　<li>ログアウト</li>
　</ul>
<p class=name>さんお疲れ様です！</p>

   @section('content')
<table>
  <tr>
    <th>id</th>
    <th>name</th>
    <th>age</th>
    <th>nationality</th>
  </tr>
            

@foreach ($attendances as $attendance)
  <tr>
    <td>
      {{$attendance->id}}
    </td>
  </tr>
  @endforeach  


 <li>名前</li>
 <li>勤怠開始</li>
 <li>勤怠終了</li>
  <li>休憩時間</li>
   <li>勤務時間</li>
  </form>


</body>
</html>


