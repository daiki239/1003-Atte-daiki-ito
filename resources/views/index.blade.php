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

  



                
<form method="post" action="{{ url('/stamp') }}">
    {{ csrf_field() }}
    
    <p>
      <input type="submit" value="勤怠開始">
    </p>
  </form>

  <form method="post" action="{{ url('/stamped') }}">
    {{ csrf_field() }}
    
    <p>
      <input type="submit" value="勤怠終了">
    </p>
  </form>

  <form method="post" action="{{ url('/rest') }}">
    {{ csrf_field() }}
    
    <p>
      <input type="submit" value="休憩開始">
    </p>
  </form>


  <form method="post" action="{{ url('/rested') }}">
    {{ csrf_field() }}
    
    <p>
      <input type="submit" value="休憩終了">
    </p>
  </form>

   
             
</body>
</html>