<?php
   function send_message_winner($data){
      $title = $data['title'];
      $id = $data['id_lot'];
      $message = "Поздравляем! Вы победили в лоте $title (ссылка http://yeticave:8080/lot.php?id=$id)";
      $to = $data['email'];
      $from = "YetiCave";
      $subject = "Победа в лоте";

      $subject = "=utf-8?B?".base64_encode($subject)."?=";
      $headers = "From: $from\r\nReply-to: $from\r\nContent-type:text/plain; charset=utf-8\r\n";

      mail($to, $subject, $message, $headers);
   }