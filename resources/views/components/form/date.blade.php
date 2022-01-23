<?php
  $class=$attributes["class"];
  unset($attributes["class"]);
?>
{{ Form::text($name, $value, array_merge(["class"=>$class." date"],(array)$attributes)) }}
