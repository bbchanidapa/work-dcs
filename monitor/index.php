<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title></title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
    <script src="https://code.jquery.com/ui/1.12.0/jquery-ui.js"></script>
     <!--Team -->
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/bootswatch/3.3.7/flatly/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href=" https://cdnjs.cloudflare.com/ajax/libs/bootswatch/3.3.7/flatly/bootstrap.css">
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.0/themes/base/jquery-ui.css">
    <!-- <link rel="stylesheet" href="/resources/demos/style.css"> -->
    <!--  <link rel="stylesheet" type="text/css" href="style.css"> -->
    <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
    <script src="https://code.jquery.com/ui/1.12.0/jquery-ui.js"></script>
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <!-- Optional theme -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">
    <!-- Latest compiled and minified JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
    <style>
    body{
      position:relative;
      background: #F5F7FA;
    }
    .link{
      border: 1px solid#ccc;
      padding: 15px;
    }
/*     .nav{
  top: 0%; left: 0%;
  position:relative;
  background: #ECECEC;
  padding: 15px;
} */
    .devices{
      position: absolute;
      left: 0px;
      width : 10%;
      border: 2px solid #ccc;
      nav-right: .nav;
    }
    .traffics{
      position: absolute;
      left:180px;
      width : 500px;
      height: 370px;
      border: 1px solid #ccc;
      nav-left: .devices;
      nav-down: .warnings;
    }
    .warnings{
      position: absolute;
      top: 420px;
      left:180px;
      width : 500px;
      height: 150px;
      border: 2px solid #ccc;
      nav-left: .devices;
      nav-up: .traffics;
    }
    .ratios{
      position: absolute;
      width : 180px;
      border: 2px solid #ccc;
      nav-left: .traffics;
      nav-up: .nav;
    }
    .device{
      background-color: #E6E9ED;
      border: 1px solid #F5F7FA;
      height: 50%;
      padding: 30px;
    }
    .traffic{
      border: 1px solid #F5F7FA;
    }
    </style>
    <script>
    $(document).ready(function(){
        var position = $('.devices').position(),
            devices  = $('.devices'),
            traffics = $('.traffics'),
            ratios   = $('.ratios'),
            warnings = $('.warnings');

        traffics.offset({ top: position.top ,left:(devices.width()+20)});
        warnings.offset({ top: (position.top+traffics.height()) ,left:(devices.width()+20)});
        ratios.offset({ top: position.top ,left:(devices.width()+traffics.width()+40)});
        ratios.css({'height': devices.height()});

    });

    </script>
  </head>
  <body>
    <div class="nav">
   <!--    <a href="dashboard.html"><span class="link">Dashboard</span></a>
   <a href="devices.html"><span class="link">Devices</span></a>
   <a href="interface.html"><span class="link">Interface</span></a>
   <a href="ranking.html"><span class="link">Top 10 Ranking</span></a>
   <a href="event.html"><span class="link">Events</span></a>
   <a href="event.html"><span class="link">Network</span></a> -->
          <nav class="navbar navbar-default">
            <div class="container-fluid">
              <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-2">
                  <span class="sr-only">Toggle navigation</span>
                  <span class="icon-bar"></span>
                  <span class="icon-bar"></span>
                  <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="#">FITM Monitoring</a>
              </div>

              <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-2">
                <ul class="nav navbar-nav">
                  <li><a href="#">Dashboard <span class="sr-only">(current)</span></a></li>
                  <li><a href="#">Device</a></li>
                  <li><a href="#">Interface</a></li>
                  <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Top 10 Ranking <span class="caret"></span></a>
                    <ul class="dropdown-menu" role="menu">
                      <li><a href="#">Top 10 Network Traffic Usage</a></li>
                      <li><a href="#">Top 10 Service Total Usage</a></li>
                    </ul>
                  </li>
                  <li><a href="#">Event</a></li>
                </ul>
                <ul class="nav navbar-nav navbar-right">
                  <li><a href="#">Link</a></li>
                </ul>
              </div>
            </div>
          </nav>
    </div>

    <div class="devices">
      <div class="device" >
        <span>R124  10.77.1.2</span>
      </div>
      <div class="device" >
        <span>R330A 10.77.3.2</span>
      </div>
      <div class="device" >
        <span>R401  10.77.4.2</span>
      </div>
      <div class="device" >
        <span>R415  10.77.5.2</span>
      </div>
      <div class="device" >
        <span>R101C  10.77.6.2</span>
      </div>
      <div class="device" >
        <span>SW4503 10.77.4.1</span>
      </div>
    </div>
    <div class="traffics">
      <div class="traffic">
        <div class="progress">
          <span>R124</span><div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width: 40%"></div>
        </div>
        <span>Inbound</span><span>Outbound</span>
        <div class="progress">
            <span>R330A</span><div class="progress-bar progress-bar-info" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100" style="width: 20%"></div>
        </div>
        <span>Inbound</span><span>Outbound</span>
        <div class="progress">
          <span>A401</span><div class="progress-bar progress-bar-warning" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: 60%"></div>
        </div>
        <span>Inbound</span><span>Outbound</span>
        <div class="progress">
            <span>R415</span><div class="progress-bar progress-bar-danger" role="progressbar" aria-valuenow="80" aria-valuemin="0" aria-valuemax="100" style="width: 80%"></div>
        </div>
        <span>Inbound</span><span>Outbound</span>
        <div class="progress">
            <span>SW4503</span><div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100" style="width: 50%">
            <span class="sr-only">50% Complete (success)</span>
          </div>
        </div>
        <span>Inbound</span><span>Outbound</span>
        <div class="progress">
            <span>R101C</span><div class="progress-bar progress-bar-warning" role="progressbar" aria-valuenow="70" aria-valuemin="0" aria-valuemax="100" style="width: 70%"></div>
        </div>
        <span>Inbound</span><span>Outbound</span>
        <!--************************************-->

      </div>
    </div>
    <div class="warnings">

    </div>
    <div class="ratios">

    </div>

  <!--  <div class="panel panel-default">
      <div class="panel-heading">
        <h3 class="panel-title">Panel title</h3>
        </div>
        <div class="panel-body">
        Panel content
      </div>
    </div>-->

  </body>
</html>
