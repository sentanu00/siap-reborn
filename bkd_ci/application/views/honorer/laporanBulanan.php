<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>

<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <style type="text/css">
    html {
      font-family: Calibri, Arial, Helvetica, sans-serif;
      font-size: 11pt;
      background-color: white
    }

    a.comment-indicator:hover+div.comment {
      background: #ffd;
      position: absolute;
      display: block;
      border: 1px solid black;
      padding: 0.5em
    }

    a.comment-indicator {
      background: red;
      display: inline-block;
      border: 1px solid black;
      width: 0.5em;
      height: 0.5em
    }

    div.comment {
      display: none
    }

    table {
      border-collapse: collapse;
      page-break-after: always;
      width: 100%
    }

    .gridlines td {
      border: 1px dotted black
    }

    .gridlines th {
      border: 1px dotted black
    }

    .b {
      text-align: center
    }

    .e {
      text-align: center
    }

    .f {
      text-align: right
    }

    .inlineStr {
      text-align: left
    }

    .n {
      text-align: right
    }

    .s {
      text-align: left
    }

    td.style0 {
      vertical-align: bottom;
      border-bottom: none #000000;
      border-top: none #000000;
      border-left: none #000000;
      border-right: none #000000;
      color: #000000;
      font-family: 'Arial';
      font-size: 10pt;
      background-color: white
    }

    th.style0 {
      vertical-align: bottom;
      border-bottom: none #000000;
      border-top: none #000000;
      border-left: none #000000;
      border-right: none #000000;
      color: #000000;
      font-family: 'Arial';
      font-size: 10pt;
      background-color: white
    }

    td.style1 {
      vertical-align: bottom;
      text-align: center;
      border-bottom: 1px solid #000000 !important;
      border-top: none #000000;
      border-left: 1px solid #000000 !important;
      border-right: 1px solid #000000 !important;
      color: #000000;
      font-family: 'Arial';
      font-size: 10pt;
      background-color: white
    }

    th.style1 {
      vertical-align: bottom;
      text-align: center;
      border-bottom: 1px solid #000000 !important;
      border-top: none #000000;
      border-left: 1px solid #000000 !important;
      border-right: 1px solid #000000 !important;
      color: #000000;
      font-family: 'Arial';
      font-size: 10pt;
      background-color: white
    }

    td.style2 {
      vertical-align: bottom;
      text-align: center;
      border-bottom: none #000000;
      border-top: none #000000;
      border-left: none #000000;
      border-right: none #000000;
      color: #000000;
      font-family: 'Arial';
      font-size: 10pt;
      background-color: white
    }

    th.style2 {
      vertical-align: bottom;
      text-align: center;
      border-bottom: none #000000;
      border-top: none #000000;
      border-left: none #000000;
      border-right: none #000000;
      color: #000000;
      font-family: 'Arial';
      font-size: 10pt;
      background-color: white
    }

    td.style3 {
      vertical-align: bottom;
      border-bottom: none #000000;
      border-top: none #000000;
      border-left: none #000000;
      border-right: none #000000;
      font-weight: bold;
      color: #000000;
      font-family: 'Arial';
      font-size: 10pt;
      background-color: white
    }

    th.style3 {
      vertical-align: bottom;
      border-bottom: none #000000;
      border-top: none #000000;
      border-left: none #000000;
      border-right: none #000000;
      font-weight: bold;
      color: #000000;
      font-family: 'Arial';
      font-size: 10pt;
      background-color: white
    }

    td.style4 {
      vertical-align: bottom;
      text-align: center;
      border-bottom: none #000000;
      border-top: none #000000;
      border-left: none #000000;
      border-right: none #000000;
      font-weight: bold;
      color: #000000;
      font-family: 'Arial';
      font-size: 10pt;
      background-color: white
    }

    th.style4 {
      vertical-align: bottom;
      text-align: center;
      border-bottom: none #000000;
      border-top: none #000000;
      border-left: none #000000;
      border-right: none #000000;
      font-weight: bold;
      color: #000000;
      font-family: 'Arial';
      font-size: 10pt;
      background-color: white
    }

    td.style5 {
      vertical-align: bottom;
      text-align: left;
      padding-left: 0px;
      border-bottom: none #000000;
      border-top: none #000000;
      border-left: none #000000;
      border-right: none #000000;
      color: #000000;
      font-family: 'Arial';
      font-size: 10pt;
      background-color: white
    }

    th.style5 {
      vertical-align: bottom;
      text-align: left;
      padding-left: 0px;
      border-bottom: none #000000;
      border-top: none #000000;
      border-left: none #000000;
      border-right: none #000000;
      color: #000000;
      font-family: 'Arial';
      font-size: 10pt;
      background-color: white
    }

    td.style6 {
      vertical-align: bottom;
      text-align: center;
      border-bottom: none #000000;
      border-top: none #000000;
      border-left: none #000000;
      border-right: none #000000;
      font-weight: bold;
      text-decoration: underline;
      font-style: italic;
      color: #000000;
      font-family: 'Arial';
      font-size: 10pt;
      background-color: white
    }

    th.style6 {
      vertical-align: bottom;
      text-align: center;
      border-bottom: none #000000;
      border-top: none #000000;
      border-left: none #000000;
      border-right: none #000000;
      font-weight: bold;
      text-decoration: underline;
      font-style: italic;
      color: #000000;
      font-family: 'Arial';
      font-size: 10pt;
      background-color: white
    }

    td.style7 {
      vertical-align: bottom;
      text-align: center;
      border-bottom: none #000000;
      border-top: none #000000;
      border-left: none #000000;
      border-right: none #000000;
      font-weight: bold;
      font-style: italic;
      color: #000000;
      font-family: 'Arial';
      font-size: 10pt;
      background-color: white
    }

    th.style7 {
      vertical-align: bottom;
      text-align: center;
      border-bottom: none #000000;
      border-top: none #000000;
      border-left: none #000000;
      border-right: none #000000;
      font-weight: bold;
      font-style: italic;
      color: #000000;
      font-family: 'Arial';
      font-size: 10pt;
      background-color: white
    }

    td.style8 {
      vertical-align: bottom;
      text-align: center;
      border-bottom: 1px solid #000000 !important;
      border-top: none #000000;
      border-left: 1px solid #000000 !important;
      border-right: 1px solid #000000 !important;
      color: #000000;
      font-family: 'Arial';
      font-size: 10pt;
      background-color: white
    }

    th.style8 {
      vertical-align: bottom;
      text-align: center;
      border-bottom: 1px solid #000000 !important;
      border-top: none #000000;
      border-left: 1px solid #000000 !important;
      border-right: 1px solid #000000 !important;
      color: #000000;
      font-family: 'Arial';
      font-size: 10pt;
      background-color: white
    }

    td.style9 {
      vertical-align: bottom;
      border-bottom: 1px solid #000000 !important;
      border-top: none #000000;
      border-left: 1px solid #000000 !important;
      border-right: 1px solid #000000 !important;
      color: #000000;
      font-family: 'Arial';
      font-size: 10pt;
      background-color: white
    }

    th.style9 {
      vertical-align: bottom;
      border-bottom: 1px solid #000000 !important;
      border-top: none #000000;
      border-left: 1px solid #000000 !important;
      border-right: 1px solid #000000 !important;
      color: #000000;
      font-family: 'Arial';
      font-size: 10pt;
      background-color: white
    }

    td.style10 {
      vertical-align: bottom;
      text-align: center;
      border-bottom: none #000000;
      border-top: none #000000;
      border-left: 1px solid #000000 !important;
      border-right: 1px solid #000000 !important;
      font-weight: bold;
      color: #000000;
      font-family: 'Arial';
      font-size: 10pt;
      background-color: white
    }

    th.style10 {
      vertical-align: bottom;
      text-align: center;
      border-bottom: none #000000;
      border-top: none #000000;
      border-left: 1px solid #000000 !important;
      border-right: 1px solid #000000 !important;
      font-weight: bold;
      color: #000000;
      font-family: 'Arial';
      font-size: 10pt;
      background-color: white
    }

    td.style11 {
      vertical-align: middle;
      text-align: center;
      border-bottom: none #000000;
      border-top: 2px solid #000000 !important;
      border-left: 1px solid #000000 !important;
      border-right: 1px solid #000000 !important;
      font-weight: bold;
      color: #000000;
      font-family: 'Arial';
      font-size: 10pt;
      background-color: white
    }

    th.style11 {
      vertical-align: middle;
      text-align: center;
      border-bottom: none #000000;
      border-top: 2px solid #000000 !important;
      border-left: 1px solid #000000 !important;
      border-right: 1px solid #000000 !important;
      font-weight: bold;
      color: #000000;
      font-family: 'Arial';
      font-size: 10pt;
      background-color: white
    }

    td.style12 {
      vertical-align: bottom;
      text-align: center;
      border-bottom: none #000000;
      border-top: 2px solid #000000 !important;
      border-left: 1px solid #000000 !important;
      border-right: 1px solid #000000 !important;
      font-weight: bold;
      color: #000000;
      font-family: 'Arial';
      font-size: 10pt;
      background-color: white
    }

    th.style12 {
      vertical-align: bottom;
      text-align: center;
      border-bottom: none #000000;
      border-top: 2px solid #000000 !important;
      border-left: 1px solid #000000 !important;
      border-right: 1px solid #000000 !important;
      font-weight: bold;
      color: #000000;
      font-family: 'Arial';
      font-size: 10pt;
      background-color: white
    }

    td.style13 {
      vertical-align: bottom;
      text-align: center;
      border-bottom: 2px solid #000000 !important;
      border-top: none #000000;
      border-left: 1px solid #000000 !important;
      border-right: 1px solid #000000 !important;
      font-weight: bold;
      color: #000000;
      font-family: 'Arial';
      font-size: 10pt;
      background-color: white
    }

    th.style13 {
      vertical-align: bottom;
      text-align: center;
      border-bottom: 2px solid #000000 !important;
      border-top: none #000000;
      border-left: 1px solid #000000 !important;
      border-right: 1px solid #000000 !important;
      font-weight: bold;
      color: #000000;
      font-family: 'Arial';
      font-size: 10pt;
      background-color: white
    }

    td.style14 {
      vertical-align: bottom;
      text-align: center;
      border-bottom: 2px solid #000000 !important;
      border-top: none #000000;
      border-left: 1px solid #000000 !important;
      border-right: 1px solid #000000 !important;
      font-weight: bold;
      color: #000000;
      font-family: 'Arial';
      font-size: 10pt;
      background-color: white
    }

    th.style14 {
      vertical-align: bottom;
      text-align: center;
      border-bottom: 2px solid #000000 !important;
      border-top: none #000000;
      border-left: 1px solid #000000 !important;
      border-right: 1px solid #000000 !important;
      font-weight: bold;
      color: #000000;
      font-family: 'Arial';
      font-size: 10pt;
      background-color: white
    }

    td.style15 {
      vertical-align: bottom;
      text-align: center;
      border-bottom: 2px solid #000000 !important;
      border-top: none #000000;
      border-left: 1px solid #000000 !important;
      border-right: 1px solid #000000 !important;
      font-weight: bold;
      color: #000000;
      font-family: 'Arial';
      font-size: 10pt;
      background-color: white
    }

    th.style15 {
      vertical-align: bottom;
      text-align: center;
      border-bottom: 2px solid #000000 !important;
      border-top: none #000000;
      border-left: 1px solid #000000 !important;
      border-right: 1px solid #000000 !important;
      font-weight: bold;
      color: #000000;
      font-family: 'Arial';
      font-size: 10pt;
      background-color: white
    }

    td.style16 {
      vertical-align: bottom;
      text-align: center;
      border-bottom: 1px solid #000000 !important;
      border-top: none #000000;
      border-left: 1px solid #000000 !important;
      border-right: 1px solid #000000 !important;
      color: #000000;
      font-family: 'Arial';
      font-size: 10pt;
      background-color: white
    }

    th.style16 {
      vertical-align: bottom;
      text-align: center;
      border-bottom: 1px solid #000000 !important;
      border-top: none #000000;
      border-left: 1px solid #000000 !important;
      border-right: 1px solid #000000 !important;
      color: #000000;
      font-family: 'Arial';
      font-size: 10pt;
      background-color: white
    }

    td.style17 {
      vertical-align: bottom;
      text-align: center;
      border-bottom: 1px solid #000000 !important;
      border-top: none #000000;
      border-left: 1px solid #000000 !important;
      border-right: 1px solid #000000 !important;
      color: #000000;
      font-family: 'Arial';
      font-size: 10pt;
      background-color: white
    }

    th.style17 {
      vertical-align: bottom;
      text-align: center;
      border-bottom: 1px solid #000000 !important;
      border-top: none #000000;
      border-left: 1px solid #000000 !important;
      border-right: 1px solid #000000 !important;
      color: #000000;
      font-family: 'Arial';
      font-size: 10pt;
      background-color: white
    }

    td.style18 {
      vertical-align: bottom;
      text-align: center;
      border-bottom: 1px solid #000000 !important;
      border-top: none #000000;
      border-left: 1px solid #000000 !important;
      border-right: 1px solid #000000 !important;
      color: #000000;
      font-family: 'Arial';
      font-size: 10pt;
      background-color: white
    }

    th.style18 {
      vertical-align: bottom;
      text-align: center;
      border-bottom: 1px solid #000000 !important;
      border-top: none #000000;
      border-left: 1px solid #000000 !important;
      border-right: 1px solid #000000 !important;
      color: #000000;
      font-family: 'Arial';
      font-size: 10pt;
      background-color: white
    }

    td.style19 {
      vertical-align: bottom;
      text-align: center;
      border-bottom: 1px solid #000000 !important;
      border-top: none #000000;
      border-left: 1px solid #000000 !important;
      border-right: 1px solid #000000 !important;
      color: #000000;
      font-family: 'Arial';
      font-size: 10pt;
      background-color: white
    }

    th.style19 {
      vertical-align: bottom;
      text-align: center;
      border-bottom: 1px solid #000000 !important;
      border-top: none #000000;
      border-left: 1px solid #000000 !important;
      border-right: 1px solid #000000 !important;
      color: #000000;
      font-family: 'Arial';
      font-size: 10pt;
      background-color: white
    }

    td.style20 {
      vertical-align: middle;
      text-align: center;
      border-bottom: none #000000;
      border-top: 2px solid #000000 !important;
      border-left: 1px solid #000000 !important;
      border-right: 1px solid #000000 !important;
      font-weight: bold;
      color: #000000;
      font-family: 'Arial';
      font-size: 10pt;
      background-color: white
    }

    th.style20 {
      vertical-align: middle;
      text-align: center;
      border-bottom: none #000000;
      border-top: 2px solid #000000 !important;
      border-left: 1px solid #000000 !important;
      border-right: 1px solid #000000 !important;
      font-weight: bold;
      color: #000000;
      font-family: 'Arial';
      font-size: 10pt;
      background-color: white
    }

    td.style21 {
      vertical-align: middle;
      text-align: center;
      border-bottom: 2px solid #000000 !important;
      border-top: none #000000;
      border-left: 1px solid #000000 !important;
      border-right: 1px solid #000000 !important;
      color: #000000;
      font-family: 'Arial';
      font-size: 10pt;
      background-color: white
    }

    th.style21 {
      vertical-align: middle;
      text-align: center;
      border-bottom: 2px solid #000000 !important;
      border-top: none #000000;
      border-left: 1px solid #000000 !important;
      border-right: 1px solid #000000 !important;
      color: #000000;
      font-family: 'Arial';
      font-size: 10pt;
      background-color: white
    }

    td.style22 {
      vertical-align: middle;
      text-align: center;
      border-bottom: none #000000;
      border-top: none #000000;
      border-left: 1px solid #000000 !important;
      border-right: 1px solid #000000 !important;
      font-weight: bold;
      color: #000000;
      font-family: 'Arial';
      font-size: 10pt;
      background-color: white
    }

    th.style22 {
      vertical-align: middle;
      text-align: center;
      border-bottom: none #000000;
      border-top: none #000000;
      border-left: 1px solid #000000 !important;
      border-right: 1px solid #000000 !important;
      font-weight: bold;
      color: #000000;
      font-family: 'Arial';
      font-size: 10pt;
      background-color: white
    }

    td.style23 {
      vertical-align: top;
      text-align: center;
      border-bottom: 1px solid #000000 !important;
      border-top: none #000000;
      border-left: 1px solid #000000 !important;
      border-right: 1px solid #000000 !important;
      color: #000000;
      font-family: 'Arial';
      font-size: 10pt;
      background-color: white
    }

    th.style23 {
      vertical-align: top;
      text-align: center;
      border-bottom: 1px solid #000000 !important;
      border-top: none #000000;
      border-left: 1px solid #000000 !important;
      border-right: 1px solid #000000 !important;
      color: #000000;
      font-family: 'Arial';
      font-size: 10pt;
      background-color: white
    }

    td.style24 {
      vertical-align: top;
      border-bottom: 1px solid #000000 !important;
      border-top: none #000000;
      border-left: 1px solid #000000 !important;
      border-right: 1px solid #000000 !important;
      color: #000000;
      font-family: 'Arial';
      font-size: 10pt;
      background-color: white
    }

    th.style24 {
      vertical-align: top;
      border-bottom: 1px solid #000000 !important;
      border-top: none #000000;
      border-left: 1px solid #000000 !important;
      border-right: 1px solid #000000 !important;
      color: #000000;
      font-family: 'Arial';
      font-size: 10pt;
      background-color: white
    }

    td.style25 {
      vertical-align: top;
      text-align: center;
      border-bottom: 1px solid #000000 !important;
      border-top: none #000000;
      border-left: 1px solid #000000 !important;
      border-right: 1px solid #000000 !important;
      color: #000000;
      font-family: 'Arial';
      font-size: 10pt;
      background-color: white
    }

    th.style25 {
      vertical-align: top;
      text-align: center;
      border-bottom: 1px solid #000000 !important;
      border-top: none #000000;
      border-left: 1px solid #000000 !important;
      border-right: 1px solid #000000 !important;
      color: #000000;
      font-family: 'Arial';
      font-size: 10pt;
      background-color: white
    }

    td.style26 {
      vertical-align: top;
      text-align: center;
      border-bottom: 1px solid #000000 !important;
      border-top: none #000000;
      border-left: 1px solid #000000 !important;
      border-right: 1px solid #000000 !important;
      color: #000000;
      font-family: 'Arial';
      font-size: 10pt;
      background-color: white
    }

    th.style26 {
      vertical-align: top;
      text-align: center;
      border-bottom: 1px solid #000000 !important;
      border-top: none #000000;
      border-left: 1px solid #000000 !important;
      border-right: 1px solid #000000 !important;
      color: #000000;
      font-family: 'Arial';
      font-size: 10pt;
      background-color: white
    }

    td.style27 {
      vertical-align: top;
      border-bottom: none #000000;
      border-top: none #000000;
      border-left: none #000000;
      border-right: none #000000;
      color: #000000;
      font-family: 'Arial';
      font-size: 10pt;
      background-color: white
    }

    th.style27 {
      vertical-align: top;
      border-bottom: none #000000;
      border-top: none #000000;
      border-left: none #000000;
      border-right: none #000000;
      color: #000000;
      font-family: 'Arial';
      font-size: 10pt;
      background-color: white
    }

    td.style28 {
      vertical-align: middle;
      text-align: center;
      border-bottom: none #000000;
      border-top: 2px solid #000000 !important;
      border-left: 1px solid #000000 !important;
      border-right: 1px solid #000000 !important;
      font-weight: bold;
      color: #000000;
      font-family: 'Arial';
      font-size: 10pt;
      background-color: white
    }

    th.style28 {
      vertical-align: middle;
      text-align: center;
      border-bottom: none #000000;
      border-top: 2px solid #000000 !important;
      border-left: 1px solid #000000 !important;
      border-right: 1px solid #000000 !important;
      font-weight: bold;
      color: #000000;
      font-family: 'Arial';
      font-size: 10pt;
      background-color: white
    }

    td.style29 {
      vertical-align: middle;
      text-align: center;
      border-bottom: none #000000;
      border-top: none #000000;
      border-left: 1px solid #000000 !important;
      border-right: 1px solid #000000 !important;
      font-weight: bold;
      color: #000000;
      font-family: 'Arial';
      font-size: 10pt;
      background-color: white
    }

    th.style29 {
      vertical-align: middle;
      text-align: center;
      border-bottom: none #000000;
      border-top: none #000000;
      border-left: 1px solid #000000 !important;
      border-right: 1px solid #000000 !important;
      font-weight: bold;
      color: #000000;
      font-family: 'Arial';
      font-size: 10pt;
      background-color: white
    }

    td.style30 {
      vertical-align: middle;
      text-align: center;
      border-bottom: 2px solid #000000 !important;
      border-top: none #000000;
      border-left: 1px solid #000000 !important;
      border-right: 1px solid #000000 !important;
      font-weight: bold;
      color: #000000;
      font-family: 'Arial';
      font-size: 10pt;
      background-color: white
    }

    th.style30 {
      vertical-align: middle;
      text-align: center;
      border-bottom: 2px solid #000000 !important;
      border-top: none #000000;
      border-left: 1px solid #000000 !important;
      border-right: 1px solid #000000 !important;
      font-weight: bold;
      color: #000000;
      font-family: 'Arial';
      font-size: 10pt;
      background-color: white
    }

    td.style31 {
      vertical-align: bottom;
      text-align: center;
      border-bottom: none #000000;
      border-top: 2px solid #000000 !important;
      border-left: 1px solid #000000 !important;
      border-right: none #000000;
      font-weight: bold;
      color: #000000;
      font-family: 'Arial';
      font-size: 10pt;
      background-color: white
    }

    th.style31 {
      vertical-align: bottom;
      text-align: center;
      border-bottom: none #000000;
      border-top: 2px solid #000000 !important;
      border-left: 1px solid #000000 !important;
      border-right: none #000000;
      font-weight: bold;
      color: #000000;
      font-family: 'Arial';
      font-size: 10pt;
      background-color: white
    }

    td.style32 {
      vertical-align: bottom;
      text-align: center;
      border-bottom: none #000000;
      border-top: 2px solid #000000 !important;
      border-left: none #000000;
      border-right: 1px solid #000000 !important;
      font-weight: bold;
      color: #000000;
      font-family: 'Arial';
      font-size: 10pt;
      background-color: white
    }

    th.style32 {
      vertical-align: bottom;
      text-align: center;
      border-bottom: none #000000;
      border-top: 2px solid #000000 !important;
      border-left: none #000000;
      border-right: 1px solid #000000 !important;
      font-weight: bold;
      color: #000000;
      font-family: 'Arial';
      font-size: 10pt;
      background-color: white
    }

    td.style33 {
      vertical-align: bottom;
      text-align: center;
      border-bottom: 1px solid #000000 !important;
      border-top: none #000000;
      border-left: 1px solid #000000 !important;
      border-right: none #000000;
      font-weight: bold;
      color: #000000;
      font-family: 'Arial';
      font-size: 10pt;
      background-color: white
    }

    th.style33 {
      vertical-align: bottom;
      text-align: center;
      border-bottom: 1px solid #000000 !important;
      border-top: none #000000;
      border-left: 1px solid #000000 !important;
      border-right: none #000000;
      font-weight: bold;
      color: #000000;
      font-family: 'Arial';
      font-size: 10pt;
      background-color: white
    }

    td.style34 {
      vertical-align: bottom;
      text-align: center;
      border-bottom: 1px solid #000000 !important;
      border-top: none #000000;
      border-left: none #000000;
      border-right: 1px solid #000000 !important;
      font-weight: bold;
      color: #000000;
      font-family: 'Arial';
      font-size: 10pt;
      background-color: white
    }

    th.style34 {
      vertical-align: bottom;
      text-align: center;
      border-bottom: 1px solid #000000 !important;
      border-top: none #000000;
      border-left: none #000000;
      border-right: 1px solid #000000 !important;
      font-weight: bold;
      color: #000000;
      font-family: 'Arial';
      font-size: 10pt;
      background-color: white
    }

    td.style35 {
      vertical-align: bottom;
      text-align: center;
      border-bottom: none #000000;
      border-top: none #000000;
      border-left: none #000000;
      border-right: none #000000;
      font-weight: bold;
      color: #000000;
      font-family: 'Arial';
      font-size: 14pt;
      background-color: white
    }

    th.style35 {
      vertical-align: bottom;
      text-align: center;
      border-bottom: none #000000;
      border-top: none #000000;
      border-left: none #000000;
      border-right: none #000000;
      font-weight: bold;
      color: #000000;
      font-family: 'Arial';
      font-size: 14pt;
      background-color: white
    }

    td.style36 {
      vertical-align: bottom;
      text-align: right;
      padding-right: 0px;
      border-bottom: none #000000;
      border-top: none #000000;
      border-left: none #000000;
      border-right: none #000000;
      font-weight: bold;
      color: #000000;
      font-family: 'Arial';
      font-size: 10pt;
      background-color: white
    }

    th.style36 {
      vertical-align: bottom;
      text-align: right;
      padding-right: 0px;
      border-bottom: none #000000;
      border-top: none #000000;
      border-left: none #000000;
      border-right: none #000000;
      font-weight: bold;
      color: #000000;
      font-family: 'Arial';
      font-size: 10pt;
      background-color: white
    }

    td.style37 {
      vertical-align: bottom;
      text-align: left;
      padding-left: 0px;
      border-bottom: none #000000;
      border-top: none #000000;
      border-left: none #000000;
      border-right: none #000000;
      font-weight: bold;
      color: #000000;
      font-family: 'Arial';
      font-size: 10pt;
      background-color: white
    }

    th.style37 {
      vertical-align: bottom;
      text-align: left;
      padding-left: 0px;
      border-bottom: none #000000;
      border-top: none #000000;
      border-left: none #000000;
      border-right: none #000000;
      font-weight: bold;
      color: #000000;
      font-family: 'Arial';
      font-size: 10pt;
      background-color: white
    }

    td.style38 {
      vertical-align: bottom;
      text-align: left;
      padding-left: 0px;
      border-bottom: none #000000;
      border-top: none #000000;
      border-left: none #000000;
      border-right: none #000000;
      font-weight: bold;
      font-style: italic;
      color: #000000;
      font-family: 'Arial';
      font-size: 10pt;
      background-color: white
    }

    th.style38 {
      vertical-align: bottom;
      text-align: left;
      padding-left: 0px;
      border-bottom: none #000000;
      border-top: none #000000;
      border-left: none #000000;
      border-right: none #000000;
      font-weight: bold;
      font-style: italic;
      color: #000000;
      font-family: 'Arial';
      font-size: 10pt;
      background-color: white
    }

    td.style39 {
      vertical-align: bottom;
      text-align: right;
      padding-right: 0px;
      border-bottom: none #000000;
      border-top: none #000000;
      border-left: none #000000;
      border-right: none #000000;
      color: #000000;
      font-family: 'Arial';
      font-size: 10pt;
      background-color: white
    }

    th.style39 {
      vertical-align: bottom;
      text-align: right;
      padding-right: 0px;
      border-bottom: none #000000;
      border-top: none #000000;
      border-left: none #000000;
      border-right: none #000000;
      color: #000000;
      font-family: 'Arial';
      font-size: 10pt;
      background-color: white
    }

    td.style40 {
      vertical-align: bottom;
      text-align: right;
      padding-right: 0px;
      border-bottom: none #000000;
      border-top: none #000000;
      border-left: none #000000;
      border-right: none #000000;
      font-weight: bold;
      text-decoration: underline;
      font-style: italic;
      color: #000000;
      font-family: 'Arial';
      font-size: 10pt;
      background-color: white
    }

    th.style40 {
      vertical-align: bottom;
      text-align: right;
      padding-right: 0px;
      border-bottom: none #000000;
      border-top: none #000000;
      border-left: none #000000;
      border-right: none #000000;
      font-weight: bold;
      text-decoration: underline;
      font-style: italic;
      color: #000000;
      font-family: 'Arial';
      font-size: 10pt;
      background-color: white
    }

    td.style41 {
      vertical-align: bottom;
      text-align: right;
      padding-right: 0px;
      border-bottom: none #000000;
      border-top: none #000000;
      border-left: none #000000;
      border-right: none #000000;
      font-weight: bold;
      font-style: italic;
      color: #000000;
      font-family: 'Arial';
      font-size: 10pt;
      background-color: white
    }

    th.style41 {
      vertical-align: bottom;
      text-align: right;
      padding-right: 0px;
      border-bottom: none #000000;
      border-top: none #000000;
      border-left: none #000000;
      border-right: none #000000;
      font-weight: bold;
      font-style: italic;
      color: #000000;
      font-family: 'Arial';
      font-size: 10pt;
      background-color: white
    }

    .row10 td {
      padding: 5px
    }
  </style>
</head>

<body>
  <style>
    @page {}

    body {}
  </style>
  <table border="0" cellpadding="0" cellspacing="0" id="sheet0" class="sheet0">
    <col class="col0">
    <col class="col1">
    <col class="col2">
    <col class="col5">
    <col class="col9">
    <col class="col10">
    <col class="col11">
    <col class="col12">
    <col class="col13">
    <col class="col14">
    <col class="col15">
    <thead>
      <tr class="row0">
        <td class="column0 style35 s style35" colspan="14">LAPORAN BULANAN</td>
        <td class="column14">&nbsp;</td>
        <td class="column15">&nbsp;</td>
      </tr>
      <tr class="row1">
        <!-- <td class="column0 style36 s style36" colspan="5"></td> -->
        <td class="column0 style35 s style35" colspan="11">DAFTAR NAMA-NAMA NON ASN</td>
        <td class="column14">&nbsp;</td>
        <td class="column15">&nbsp;</td>
      </tr>
      <tr class="row2">
        <!-- <td class="column0 style36 s style36" colspan="5">PADA UNIT SATUAN KERJA</td>
        <td class="column7 style4 s">:</td>
        <td class="column8 style38 s style38" colspan="5"><?php echo $satker_nama; ?></td> -->
        <td class="column0 style35 s style35" colspan="11"><?php echo $satker_nama; ?></td>
        <td class="column14">&nbsp;</td>
        <td class="column15">&nbsp;</td>
      </tr>
      <tr class="row3">
        <td class="column0 style35 s style35" colspan="11"><?php echo "KEADAAN BULAN " . strtoupper(SiteHelpers::getReporting(date('Y-m-d'))); ?></td>
        <!-- <td class="column0 style36 s style36" colspan="5">KEADAAN BULAN</td>
        <td class="column7 style4 s">:</td>
         -->
        <td class="column14">&nbsp;</td>
        <td class="column15">&nbsp;</td>
      </tr>
    </thead>
    <tbody>
      <tr class="row4">
        <td class="column0">&nbsp;</td>
        <td class="column1">&nbsp;</td>
        <td class="column2">&nbsp;</td>
        <td class="column5">&nbsp;</td>
        <td class="column9">&nbsp;</td>
        <td class="column10">&nbsp;</td>
        <td class="column11">&nbsp;</td>
        <td class="column12">&nbsp;</td>
        <td class="column13">&nbsp;</td>
        <td class="column14">&nbsp;</td>
        <td class="column15">&nbsp;</td>
      </tr>
      <tr class="row5">
        <td class="column0">&nbsp;</td>
        <td class="column1">&nbsp;</td>
        <td class="column2">&nbsp;</td>
        <td class="column5">&nbsp;</td>
        <td class="column9">&nbsp;</td>
        <td class="column10">&nbsp;</td>
        <td class="column11">&nbsp;</td>
        <td class="column12">&nbsp;</td>
        <td class="column13">&nbsp;</td>
        <td class="column14">&nbsp;</td>
        <td class="column15">&nbsp;</td>
      </tr>
      <tr class="row6">
        <td class="column0 style28 s style30" rowspan="3">NO</td>
        <td class="column1 style20 s">NAMA LENGKAP</td>
        <td class="column2 style12 s">TEMPAT</td>
        <td class="column5 style11 s">PENDIDIKAN</td>
        <td class="column9 style12 s">STATUS</td>
        <td class="column10 style12 s">KAWIN /</td>
        <td class="column11 style12 s">JENIS</td>
        <td class="column12 style28 s style30" rowspan="3">AGAMA</td>
        <td class="column13 style28 s style30" rowspan="3">KET.</td>
        <td class="column14">&nbsp;</td>
        <td class="column15">&nbsp;</td>
      </tr>
      <tr class="row7">
        <td class="column1 style22 s">N I K</td>
        <td class="column2 style10 s">TGL. LHR</td>
        <td class="column5 style10 s">TAHUN</td>
        <td class="column9 style10 s">KEPEGAWAIAN</td>
        <td class="column10 style10 s">BELUM</td>
        <td class="column11 style10 s">KELAMIN</td>
        <td class="column14">&nbsp;</td>
        <td class="column15">&nbsp;</td>
      </tr>
      <tr class="row8">
        <td class="column1 style21 null"></td>
        <td class="column2 style13 null"></td>
        <td class="column5 style13 null"></td>
        <td class="column9 style13 null"></td>
        <td class="column10 style13 null"></td>
        <td class="column11 style13 null"></td>
        <td class="column14">&nbsp;</td>
        <td class="column15">&nbsp;</td>
      </tr>
      <tr class="row9">
        <td class="column0 style1 n">1</td>
        <td class="column1 style1 n">2</td>
        <td class="column2 style1 n">3</td>
        <td class="column5 style1 n">6</td>
        <td class="column9 style1 n">10</td>
        <td class="column10 style1 n">11</td>
        <td class="column11 style1 n">12</td>
        <td class="column12 style1 n">13</td>
        <td class="column13 style1 n">14</td>
        <td class="column14">&nbsp;</td>
        <td class="column15">&nbsp;</td>
      </tr>
      <?php
      $i = 1;
      foreach ($row as $peg) {
        $diklat = $this->model->getdiklat($peg->PEGAWAI_ID);
      ?>
        <tr class="row10">
          <td class="column0 style23 null"><?php echo $i++; ?></td>
          <td class="column1 style24 null"><?php echo $peg->NAMA_LENGKAP; ?><br /><?php echo $peg->NIK; ?></td>
          <td class="column2 style23 null"><?php echo $peg->TEMPAT_LAHIR; ?><br /><?php echo $peg->TANGGAL_LAHIR; ?></td>
          <td class="column5 style23 null"><?php echo $peg->JURUSAN; ?><br /><?php echo $peg->TAHUN; ?></td>
          <td class="column9 style23 null"><?php echo $peg->TXT_PEGAWAI; ?></td>
          <td class="column10 style23 null"><?php echo $peg->TXT_KAWIN; ?></td>
          <td class="column11 style23 null"><?php echo $peg->TXT_KELAMIN; ?></td>
          <td class="column12 style23 null"><?php echo $peg->TXT_AGAMA; ?></td>
          <td class="column13 style23 null"></td>
          <td class="column14">&nbsp;</td>
          <td class="column15">&nbsp;</td>
        </tr>
      <?
      }
      ?>

      <tr class="row12">
        <td class="column0">&nbsp;</td>
        <td class="column1">&nbsp;</td>
        <td class="column2">&nbsp;</td>
        <td class="column5">&nbsp;</td>
        <td class="column9">&nbsp;</td>
        <td class="column10">&nbsp;</td>
        <td class="column11">&nbsp;</td>
        <td class="column12">&nbsp;</td>
        <td class="column13">&nbsp;</td>
        <td class="column14">&nbsp;</td>
        <td class="column15">&nbsp;</td>
      </tr>
      <tr class="row13">
        <td class="column0 style40 s style40" colspan="5">
        <td class="column0 style39 s style39" colspan="4" style="text-align:center">Probolinggo, <?php echo SiteHelpers::datereport(date('Y-m-d')); ?></td>
        <td class="column13 style5 null"></td>
        <td class="column14 style5 null"></td>
      </tr>
      <tr class="row14">
        <td class="column0">&nbsp;</td>
        <td class="column1">&nbsp;</td>
        <td class="column2">&nbsp;</td>
        <td class="column5">&nbsp;</td>
        <td class="column9">&nbsp;</td>
        <td class="column10">&nbsp;</td>
        <td class="column11">&nbsp;</td>
        <td class="column12">&nbsp;</td>
        <td class="column13">&nbsp;</td>
        <td class="column14">&nbsp;</td>
        <td class="column15">&nbsp;</td>
      </tr>
      <tr class="row15">
        <td class="column0 style40 s style40" colspan="5">
        <td class="column0 style36 s style36" colspan="4" style="text-align:center"><?php echo $ttd->JABATAN; ?></td>
        <td class="column14 style4 null"></td>
        <td class="column15 style4 null"></td>
      </tr>
      <tr class="row16">
        <td class="column0 style40 s style40" colspan="5">
        <td class="column0 style36 s style36" colspan="4" style="text-align:center"></td>
        <td class="column13 style4 null"></td>
        <td class="column14 style4 null"></td>
      </tr>
      <tr class="row17">
        <td class="column0">&nbsp;</td>
        <td class="column1">&nbsp;</td>
        <td class="column2">&nbsp;</td>
        <td class="column5">&nbsp;</td>
        <td class="column9">&nbsp;</td>
        <td class="column10">&nbsp;</td>
        <td class="column11 style3 null"></td>
        <td class="column12 style3 null"></td>
        <td class="column13 style3 null"></td>
        <td class="column14 style3 null"></td>
        <td class="column15 style3 null"></td>
      </tr>
      <tr class="row18">
        <td class="column0">&nbsp;</td>
        <td class="column1">&nbsp;</td>
        <td class="column2">&nbsp;</td>
        <td class="column3">&nbsp;</td>
        <td class="column4">&nbsp;</td>
        <td class="column5">&nbsp;</td>
        <td class="column9">&nbsp;</td>
        <td class="column10">&nbsp;</td>
        <td class="column11 style3 null"></td>
        <td class="column12 style3 null"></td>
        <td class="column13 style3 null"></td>
        <td class="column14 style3 null"></td>
        <td class="column15 style3 null"></td>
      </tr>
      <tr class="row19">
        <td class="column0">&nbsp;</td>
        <td class="column1">&nbsp;</td>
        <td class="column2">&nbsp;</td>
        <td class="column5">&nbsp;</td>
        <td class="column9">&nbsp;</td>
        <td class="column10">&nbsp;</td>
        <td class="column11 style3 null"></td>
        <td class="column12 style3 null"></td>
        <td class="column13 style3 null"></td>
        <td class="column14 style3 null"></td>
        <td class="column15 style3 null"></td>
      </tr>
      <tr class="row20">
        <td class="column0 style40 s style40" colspan="5">
        <td class="column0 style40 s style40" colspan="4" style="text-align:center"><?php echo $ttd->NAMA_LENGKAP; ?></td>
        <td class="column13 style6 null"></td>
        <td class="column14 style6 null"></td>
      </tr>
      <tr class="row21">
        <td class="column0 style40 s style40" colspan="5">
        <td class="column0 style41 s style41" colspan="4" style="text-align:center"><?php echo $ttd->PANGKAT; ?></td>
        <td class="column12 style7 null"></td>
        <td class="column13 style7 null"></td>
      </tr>
      <tr class="row22">
        <td class="column0 style40 s style40" colspan="5">
        <td class="column0 style36 s style36" colspan="4" style="text-align:center">NIP. <?php echo $ttd->NIP_BARU; ?></td>
        <td class="column13 style4 null"></td>
        <td class="column14 style4 null"></td>
      </tr>
    </tbody>
  </table>
</body>

</html>
<script type="text/javascript">
  window.print();
  //setTimeout(window.close(), 10000)
</script>