<!DOCTYPE html>
<html>
<head>
 <meta charset="utf-8">
 <title>Todo List</title>
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

a{text-decoration: none;
  justify-content: right;
}

 table th {
    font-size: 20px;
    padding: 20px 50px;
    border-top: solid 1px #000;
  }

  td {
    border-bottom: 1px solid black;
  }
  tr {
    border: solid 1px gray;
  }

  .home{font-weight: bold;
    text-align: right;
    margin: 0px;
    text-align: none;
  }

  .infometion{ width: 100%;

  }

  .page{width: 100%;
    
    

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


   @section('content')
 <div class="infometion">
<table>
 
  <tr>
    <th>名前</th>
    <th>勤怠開始</th>
    <th>勤務終了</th>
    <th>休憩時間</th>
    <th>勤務時間</th>
  </tr>
</div>
  
   

@foreach ($attendances as $attendance)
  <tr>
    
    <th>  {{$attendance->user->name}}</th>
    <th> {{$attendance->start_time}}</th>
 
    <th>{{$attendance->end_time}}</th>
 
  
     <th></th>
 @endforeach 


    </td>
  </tr>
  


  

  <div class=page>
 
</div>



   


 
  </form>


</body>
</html>


