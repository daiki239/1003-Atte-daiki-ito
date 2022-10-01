<!DOCTYPE html>
<html>
<head>
 <meta charset="utf-8">
 <title>勤怠管理システム</title>
<link rel="stylesheet" href="/css/style.css">
</head>
<style>
    h2{margin-right: 50%;

    }
    .flex_right{display: flex;
                  flex-wrap: wrap;
    justify-content: space-around;
    width: 100%;
  

    }
    .user__name {
        font-size: 20px;
        font-weight: bold;
        margin: auto;
        text-align: center;
    }

    .main__card {
        width: 80%;
        margin: 0 auto;
        display: flex;
        flex-direction: column;
    }

 .flex {
        display: flex;
        justify-content: space-around;
        width: 100%;
    }
a{text-decoration: none;
  justify-content: right;
}

.home{font-weight: bold;
    text-align: right;
    margin: 0px;
    text-align: none;
    
}
 .main__card {
        width: 100%;
        margin: 0 auto;
        display: flex;
        flex-direction: column;
        background-color: #C0C0C0;
    }

.start,
    .end {
        background-color: #fff;
        border: none;
        font-size: 20px;
        font-weight: bold;
        padding: 60px 150px;
        margin: 20px;
    }

.flex__item {
        display: flex;
        justify-content: space-around;
        width: 100%;
    }

</style>
<body>

<div class="flex_right">
<h2>Atte</h2>
　<ul class=home>
  　<a class="arrow" href="/">ホーム</a>
  　<a class="arrow" href="/attendance">日付一覧</a>
  　<a class="arrow" href="/logout">ログアウト</a>
　</ul>
</div>
<div class="user__name">
        {{ Auth::user()->name }}さんお疲れ様です！
    </div>

  


<div class="main__card">   
   <div class="flex__item flex__item-1">           
     <form method="post" action="{{ url('/stamp') }}">
       {{ csrf_field() }}
       <p>
        <input type="submit" class="start time__start"  value="勤怠開始">
       </p>
     </form>
    <form method="post" action="{{ url('/stamped') }}">
    {{ csrf_field() }}
       <p>
      <input type="submit" class="end time__start" value="勤怠終了">
       </p>
     </form>
  </div>

<div class="flex__item flex__item-2">
  <form method="post" action="{{ url('/rest') }}">
    {{ csrf_field() }}
    
    <p>
      <input type="submit" class="start time__start" value="休憩開始">
    </p>
  </form>
  <form method="post" action="{{ url('/rested') }}">
    {{ csrf_field() }}
    
    <p>
      <input type="submit" class="end time__start" value="休憩終了">
    </p>
  </form>
  </div>
</div>
   
             
</body>
</html>