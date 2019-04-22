<html>
 <head>
    <Title>Registration Form</Title>

     <link rel="stylesheet" type="text/css" href="assets/css/style.css">
 </head>
 <body>
 
 <h1 id="logo">Register here!</h1>
 <!-- <p>Fill in your name and email address, then click <strong>Submit</strong> to register.</p> -->


 <form method="post" action="index.php" enctype="multipart/form-data" >
       <label> Name </label>  <input type="text" name="name" id="name"/></br></br>
       <label> Email </label> <input type="text" name="email" id="email"/></br></br>
       
       <div class="wrap">
          <div style="display: inline-flex;">
            <label for="radio11">Pria</label>
            <input type="radio" name="jk" checked id="radio11" class="radio" value="pria" />

            <label for="radio12" class="mg-left-8">Perempuan</label>
            <input type="radio" name="jk" id="radio12" class="radio" value="perempuan" />
            
          </div>
        </div>

        <label> Alamat </label>
        <textarea placeholder="Alamat" rows="20" name="alamat" id="comment_text" cols="40" class="ui-autocomplete-input" autocomplete="off" role="textbox" aria-autocomplete="list" aria-haspopup="true"></textarea>

       <div style="display: inline-flex;">
           <input type="submit" name="submit" value="Submit" />
           <input type="submit" name="load_data" value="Load Data" style="margin-left: 16px" />
           
       </div>
 </form>

 <?php
    $host = "idappserver.database.windows.net";
    // $host = "tcp:idappserver.database.windows.net:1433";
    $user = "arman";
    $pass = "Sayangshiffa1";
    $db = "armanidapp";

    try {
        $conn = new PDO("sqlsrv:server = $host; Database = $db", $user, $pass);
        $conn->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
    } catch(Exception $e) {
        echo "Failed: " . $e;
    }

    if (isset($_POST['submit'])) {
        try {
            $id = 1;
            $name = $_POST['name'];
            $email = $_POST['email'];
            $jk = $_POST['jk'];
            $alamat = $_POST['alamat'];
            $date = date("Y-m-d");
            // Insert data
            $sql_insert = "INSERT INTO [dbo].[register] (id, name, email, jk, alamat) 
                        VALUES (?,?,?,?,?)";
            $stmt = $conn->prepare($sql_insert);
            $stmt->bindValue(1, $id);
            $stmt->bindValue(2, $name);
            $stmt->bindValue(3, $email);
            $stmt->bindValue(4, $jk);
            $stmt->bindValue(5, $alamat);
            $stmt->execute();
        } catch(Exception $e) {
            echo "Failed: " . $e;
        }

        echo "<h3>Your're registered!</h3>";
    } else if (isset($_POST['load_data'])) {
        try {
            $sql_select = "SELECT * FROM [dbo].[register]";
            $stmt = $conn->query($sql_select);
            $registrants = $stmt->fetchAll(); 
            if(count($registrants) > 0) {
                echo "<caption>People who are registered:</caption>";
                echo "<table>";
                echo "<thead> <tr><th>Name</th>";
                echo "<tr><th>Email</th>";
                echo "<tr><th>Jenis Kelamin</th>";
                echo "<tr><th>Alamat</th></thead>";
                foreach($registrants as $registrant) {
                    echo "<tbody><tr><td>".$registrant['name']."</td>";
                    echo "<td>".$registrant['email']."</td>";
                    echo "<td>".$registrant['jk']."</td>";
                    echo "<td>".$registrant['alamat']."</td></tr><tbody>";
                }
                echo "</table>";
            } else {
                echo "<h3>No one is currently registered.</h3>";
            }
        } catch(Exception $e) {
            echo "Failed: " . $e;
        }
    }
 ?>
 </body>
 </html>