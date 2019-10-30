<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
  <title>Demystifying Email Design</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <style>
  .ui.header {
      border: none;
      margin: calc(2rem - .14285714em) 0 1rem;
          margin-top: calc(-0.142857em + 2rem);
      padding: 0 0;
      font-family: Lato,'Helvetica Neue',Arial,Helvetica,sans-serif;
      font-weight: 700;
      line-height: 1.28571429em;
      text-transform: none;
      color: rgba(0,0,0,.87);
  }
  .ui.header:first-child {
      margin-top: -.14285714em;
  }
  h2.ui.header {
      font-size: 1.2rem;
  }
  .ui.header > .icon + .content {
      padding-left: .75rem;
      display: table-cell;
      vertical-align: middle;
  }
  .content {
      -webkit-box-flex: 1;
      flex: 1;
  }
  h2.ui.header .sub.header {
      font-size: .8rem;
  }
  .ui[class*="right floated"].header {
      float: right;
      margin-top: 0;
      margin-left: .5em;
  }
  .ui.header .sub.header {
      display: block;
      font-weight: 400;
      padding: 0;
      margin: 0;
      font-size: 1rem;
      line-height: 1.2em;
      color: rgba(0,0,0,.6);
  }
  .ui.gmf.label, .ui.gmf.labels .label {
      background-color: #0f2233 !important;
      border-color: #0f2233 !important;
      color: #fff !important;
  }
  .ui.mini.label, .ui.mini.labels .label {
      font-size: .64285714rem;
  }
  .ui.yellow.label, .ui.yellow.labels .label {
      background-color: #f5e96d !important;
      border-color: #f5e96d !important;
      color: #000 !important;
  }

  .ui.red.label, .ui.red.labels .label {
      background-color: #e42b2b !important;
      border-color: #e42b2b !important;
      color: #fff !important;
  }

  .ui.green.label, .ui.green.labels .label {
      background-color: #5af256 !important;
      border-color: #5af256 !important;
      color: #fff !important;
  }

  .ui.unko.label, .ui.unko.labels .label {
      background-color: #188315 !important;
      border-color: #188315 !important;
      color: #fff !important;
  }
  .ui.label:last-child {
      margin-right: 0;
  }
  .ui.label:first-child {
      margin-left: 0;
  }
  .ui.label, .ui.labels .label {
      font-size: .85714286rem;
  }
  .ui.label {
      display: inline-block;
      line-height: 1;
      vertical-align: baseline;
      margin: 0 .14285714em;
          margin-right: 0.142857em;
          margin-left: 0.142857em;
      background-color: #e8e8e8;
      background-image: none;
      padding: .5833em .833em;
      color: rgba(0,0,0,.6);
      text-transform: none;
      font-weight: 700;
      border: 0 solid transparent;
          border-top-color: transparent;
          border-right-color: transparent;
          border-bottom-color: transparent;
          border-left-color: transparent;
      border-radius: .28571429rem;
      -webkit-transition: background .1s ease;
      transition: background .1s ease;
  }
  .ui.gmf.table {
      border-top: .2em solid #0f2233;
  }
  .ui.table:last-child {
      margin-bottom: 0;
  }
  .ui.table {
    font-size: 1em;
  }
  body {
      font-family: Lato,'Helvetica Neue',Arial,Helvetica,sans-serif;
      font-size: 14px;
      line-height: 1.4285em;
      color: rgba(0,0,0,.87);
  }
  .ui.table thead {
    box-shadow: none;
  }
  .ui.table thead tr:first-child > th:first-child {
    border-radius: .28571429rem 0 0 0;
  }
  .ui.compact.table th {
    padding-left: .7em;
    padding-right: .7em;
  }
  .ui.table [class*="center aligned"], .ui.table[class*="center aligned"] {
    text-align: center;
  }
  .ui.celled.table tr td, .ui.celled.table tr th {
      border: 1px solid rgba(34,36,38,.1);
  }
  .ui.table {
      width: 100%;
      background: #fff;
      margin: 1em 0;
          margin-bottom: 1em;
      border: 1px solid rgba(34,36,38,.15);
          border-top-color: rgba(34, 36, 38, 0.15);
          border-top-style: solid;
          border-top-width: 1px;
      box-shadow: none;
      border-radius: .28571429rem;
      text-align: left;
      color: rgba(0,0,0,.87);
      border-collapse: separate;
      border-spacing: 0;
  }
  </style>
</head>
  <body style="margin: 0; padding: 0;">
    <table align="center" cellpadding="0" cellspacing="0" width="800" style="border:1px solid black">
     <tr>
       <td bgcolor="#ffffff" style="height: 100px;background-color: #ff750fd1;">
         <div style="text-align: center;margin-top: 10px;margin-bottom: 10px">
           <img src="{{ url('img/icon-large.png') }}" width="125"><br>
           <p style="color: white;font-size: 25px">Pesan Dari Travoys Backend!</p>
           <p style="color: white;font-size: 25px">{{ $data or ' ' }}</p>
         </div>
       </td>
     </tr>
     <tr>
       <td bgcolor="#f0f0f0" style="padding: 40px 30px 40px 30px;">
         <div style="position:relative; min-height:500px">
           <div style="background: url({{ url('img/icon-large.png') }}) no-repeat center center; background-size: contain; opacity:.05; position: absolute; display: block; height: 100%; width:100%">&nbsp;</div>
           <div style="background:transparent">
             @yield('body')
           </div>
         </div>
       </td>
     </tr>
    </table>
  </body>
</html>
