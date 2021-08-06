<!DOCTYPE html>
<html>
<head>
  <title></title>

  <!-- Latest compiled and minified CSS -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <!-- jQuery library -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <!-- Latest compiled JavaScript -->
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

 <style type="text/css">
    
    table tr.calendor-days th{
      text-align: center;
    }
    .disabledblock{
      background-color: #b3aaaa;
    color: #fff;
    }

    table tr td{
      height: 120px;
    }
    ul.events{
      padding-inline-start: 0px;
    }

    ul.events li{
      list-style: none;
    background-color: #e6d3b3;
    margin-bottom: 1px;
    padding: 0 2px;
    }
    .addnewicn{
      float: right;
    margin-top: -8px;
    padding: 2px 8px;
    background-color: #664228;
    color: #fff;
    /* border-radius: 50%; */
    margin-right: -8px;
    }

 </style>
</head>
<body>
  <div class="page">
      <div class="container">
        <br>

        <?php 

          $days = array(
            'Sunday' => '1',
            'Monday' => '2',
            'Tuesday' => '3',
            'Wednesday' => '4',
            'Thursday' => '5',
            'Friday' => '6',
            'Saturday' => '7'
          );


          $calendor_year = date('Y');
          $calendor_month =  date('m'); 
          $calendor_date = '01';

          if(!empty($_GET['calelendar'])){
             $receive_date = $_GET['calelendar'];
             $calendor_year = date('Y', strtotime($receive_date));
             $calendor_month = date('m', strtotime($receive_date));
          }

          $calendor_f_day = $calendor_year . '-' . $calendor_month . '-'.$calendor_date;
           
          $next_month_ts = date('Y-m-d', strtotime($calendor_f_day.' +1 month'));
          $prev_month_ts = date('t',strtotime($calendor_f_day.' -1 month'));

          $next_month = date('Y-m-d', strtotime($calendor_f_day.' +1 month'));
          $prev_month = date('Y-m-d',strtotime($calendor_f_day.' -1 month'));

          $ts = strtotime($calendor_f_day);
          $last_calendor_date = date('t', $ts);

          $start_day = $day = date('l', strtotime($calendor_f_day));

        ?>
          <div class="mycalender">
              <table class="table table-bordered">
                  <tr>
                    <th colspan="5"> <?php echo date('F, Y'); ?> </th>
                    <th> 
                      <form>
                        <input type="hidden" name="calelendar" value="<?php echo $prev_month ?>"/>
                        <button type="submit" class="btn btn-sm btn-primary btn-block"> <i class="fa fa-arrow-left" aria-hidden="true"></i> PREV </button>
                      </form> 
                    </th>
                    <th> 
                      <form>
                      <input type="hidden" name="calelendar" value="<?php echo $next_month ?>"/>
                      <button type="submit" class="btn btn-sm btn-primary btn-block"> NEXT <i class="fa fa-arrow-right" aria-hidden="true"></i></button> 
                    </form>
                    </th>
                    
                  </tr>
                  <tr class="calendor-days">
                    <?php 
                    if(!empty($days)){
                      foreach ($days as $day => $name) {
                    ?>
                    <th> <?php echo $day; ?> </th>
                    <?php
                      }
                    }
                    ?>
                  </tr>
                  <tr>
                  <?php 
                    $mynumday = $days[$start_day];
                    for ($i = 1; $i < $mynumday; $i++) {  
                  ?>
                    <td class="disabledblock" > <?php echo $prev_month_ts - ($mynumday - $i-1); ?> </td>
                  <?php
                    }
                    $showLimit = $mynumday;
                    for ($i = 1; $i <= $last_calendor_date; $i++) {

                      $date = $i;
                      if($date < 10){
                        $date = '0'.$date;
                      } 
                      $event_date = $calendor_year.'-'.$calendor_month.'-'.$date;
                    ?>

                      <td class="activecolumn"> <?php echo $i; ?> 
                      <span class="addnewicn"  onclick="addNewEvent('<?php echo $event_date; ?>');">  <i class="fa fa-plus-square-o" aria-hidden="true"></i>  </span>

                      <?php if($i == 1){ ?>
                      <ul class="events">
                        <li  onclick="editEvent('1')">1. 1st Event</li>
                        <li  onclick="editEvent('2')">2. 2st Event</li>
                      </ul>
                    <?php } ?>
                    </td> 
                    <?php
                      if($showLimit++ % 7 == 0){
                      ?>
                        </tr> <tr>
                      <?php
                      }
                    }
                    $nextmoth = 0;                   
                    if(($showLimit-1) % 7 != 0){
                      for ($i = (($showLimit-1) % 7); $i < 7; $i++) { 
                       ?>
                       <td class="disabledblock"> <?php echo ++$nextmoth; ?></td>
                       <?php 
                      }
                    }
                  ?>
                  </tr>
              </table>
          </div>
      </div>
  </div>

  <div id="addNewEventModal" class="modal fade" role="dialog">
    <div class="modal-dialog"> 
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Add New Event</h4>
        </div>
        <form action="/action_page.php">
          <div class="modal-body"> 
              <div class="form-group">
                <label for="email">Email address:</label>
                <input type="email" class="form-control" id="email">
              </div>
              <div class="form-group">
                <label for="pwd">Password:</label>
                <input type="password" class="form-control" id="pwd">
              </div>
              <div class="checkbox">
                <label><input type="checkbox"> Remember me</label>
              </div>
              
          </div>
          <div class="modal-footer">
            <button type="submit" class="btn btn-default">Submit</button> 
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          </div>
        </form>
      </div> 
    </div>
  </div>

   <div id="EditEventModal" class="modal fade" role="dialog">
    <div class="modal-dialog"> 
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Edit Event</h4>
        </div>
         <form action=" ">
            <div class="modal-body">
             
                <div class="form-group">
                  <label for="email">Email address:</label>
                  <input type="email" class="form-control" id="email">
                </div>
                <div class="form-group">
                  <label for="pwd">Password:</label>
                  <input type="password" class="form-control" id="pwd">
                </div>
                <div class="checkbox">
                  <label><input type="checkbox"> Remember me</label>
                </div>
                
            
            </div>
            <div class="modal-footer">
              <button type="submit" class="btn btn-default">Submit</button>
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
          </form>
      </div> 
    </div>
  </div>

  <script type="text/javascript">


    function addNewEvent(date){
        $('#addNewEventModal').modal('show');
        // alert(date);
    }

     function editEvent(id){
      $('#EditEventModal').modal('show');
      // alert(id);
    }
    $(function(){

    })
  </script>
</body>
</html>