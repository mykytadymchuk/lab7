<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>lab3</title>
    <script>
        const ajax = new XMLHttpRequest();  // Створення об'єкта XMLHttpRequest

        function get1() {
            let clientName = document.getElementById("clientName").value;
            ajax.open("GET", "process1.php?clientName="+clientName);    // Відкриття з'єднання
            ajax.onreadystatechange = processData1;     // Призначення обробника події
            ajax.send();    // Надсилання запиту
        }

        function get2() {
            let startTime = document.getElementById("startTime").value;
            let stopTime = document.getElementById("stopTime").value;
            ajax.open("GET", "process2.php?startTime="+startTime+"&stopTime="+stopTime);
            ajax.onreadystatechange = processData2;
            ajax.send();
        }

        function get3() {
            ajax.open("GET", "process3.php");
            ajax.onreadystatechange = processData3;
            ajax.send();
        }

        function processData1() {
            if(ajax.readyState===4){
                if(ajax.status===200){
                    let resString = "<table border=2><thead><tr><th>id_sense</th><th>client_name</th><th>start</th><th>stop</th><th>in_traffic</th><th>out_traffic</th></tr></thead><tbody>" + ajax.response + "</tbody></table>";
                    document.getElementById("res").innerHTML = resString;
                }
            }
        }

        function processData2() {
            if(ajax.readyState===4){
                if(ajax.status===200){
                    let jsonRes = JSON.parse(ajax.response);
                    // console.log(jsonRes);
                    let resString = "<table border=2><thead><tr><th>id_sense</th><th>client_name</th><th>start</th><th>stop</th><th>in_traffic</th><th>out_traffic</th></tr></thead><tbody>";
                    for (let i = 0; i < jsonRes.length; i++) {
                        resString += "<tr><td>" + jsonRes[i].id_seanse + "</td><td>" + jsonRes[i].name + "</td><td>" + jsonRes[i].start + "</td><td>" + jsonRes[i].stop + "</td><td>" + jsonRes[i].in_traffic + "</td><td>" + jsonRes[i].out_traffic + "</td></tr>";
                    }
                    resString += "</tbody></table>"
                    document.getElementById("res").innerHTML = resString;
                }
            }
        }

        function processData3() {
            if(ajax.readyState===4){
                if(ajax.status===200){
                    // console.log(ajax.responseXML);
                    // console.log(ajax.responseXML.firstChild.children);
                    let xmlRes = ajax.responseXML.firstChild.children;
                    let resString = "<table border=2><thead><tr><th>id_client</th><th>name</th><th>login</th><th>password</th><th>ip</th><th>balance</th></tr></thead><tbody>";
                    for (let i = 0; i < xmlRes.length; i++) {
                        resString += "<tr><td>" + xmlRes[i].children[0].textContent + "</td><td>" + xmlRes[i].children[1].textContent + "</td><td>" + xmlRes[i].children[2].textContent + "</td><td>" + xmlRes[i].children[3].textContent + "</td><td>" + xmlRes[i].children[4].textContent + "</td><td>" + xmlRes[i].children[5].textContent + "</td></tr>";
                    }
                    resString += "</tbody></table>"
                    document.getElementById("res").innerHTML = resString;
                }
            }
        }

    </script>
</head>
<body>
    <h3>Запит №1</h3>
    <label for="clientName">Вкажіть ім'я клієнта для пошуку сеансів:</label> <br>
    <select name="clientName" id="clientName">
        <?php
            include("connect.php");
            $select = "select name from client";
            try {
                foreach($dbh->query($select) as $row) {
                    echo "<option value='$row[0]'>$row[0]</option>";
                }
            }
            catch(PDOException $ex) {
                echo $ex->GetMessage();
            }
            $dbh = null;
        ?>
    </select>
    <input type="button" value="OK" onclick="get1()">

   <br><br><br>

    <h3>Запит №2</h3>

    <label for="time">Вкажіть проміжок часу для пошуку сеансів</label> <br>
    <label for="startTime">Початок:</label>
    <input type="time" name="startTime" id="startTime" required> <br>
    <label for="stopTime">Кінець:</label>
    <input type="time" name="stopTime" id="stopTime" required> <br>
    <input type="button" value="OK" onclick="get2()">

    <br><br><br>

    <h3>Запит №3</h3>
    <span>Пошук клієнтів з від'ємним балансом рахунку:</span> <br>
    <input type="button" value="OK" onclick="get3()">

    <br><br><br>

    <p id="res"></p>

</body>
</html>