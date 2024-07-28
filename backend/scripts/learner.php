<?php

include "../includes/responses.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = isset($_POST["name"]) ? trim($_POST["name"]) : "";
    $id = isset($_POST["id-number"]) ? trim($_POST["id-number"]) : "";
    $tel = isset($_POST["tel"]) ? trim($_POST["tel"]) : "";
    $grade = isset($_POST["grade"]) ? trim($_POST["grade"]) : "";
    $bot_check = isset($_POST["bot-check"]);

    redirect(true, './bus-form.php');
} else {
    response(false, "There's a server error");
}