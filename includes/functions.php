<?php

function updateUser($i,$f,$m,$l) {
    $result = false;
    $conn = connectDB();
    $sql = "UPDATE `user` SET `first` = ?,`middle`=?,`last`=? WHERE `id`=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssi",$f,$m,$l,$i);
    $result = $stmt->execute();
    return $result;
}

function showUserEditHTML($a,$id) {
    $result = null;
    // heredoc syntax in PHP
    if($a == 'update') {
        $conn = connectDB();
        $sql = "SELECT `id`,`last`,`middle`,`first`,`doshow` FROM `user` WHERE `id` = ?";
        $stmt= $conn->prepare($sql);
        $stmt->bind_param("i",$id);
        if($stmt->execute()) {
            $data_result = $stmt->get_result();
            if($data_result->num_rows==1) {
                $row = $data_result->fetch_assoc();

            }
        }

        $first = $row['first'];
        $middle = $row['middle'];
        $last = $row['last'];
        $id = $row['id'];

        $result = <<< HTML
    <div>
        <form action="index.php" method="post">
            <div>Voornaam:<input type="text" name="first" value="$first"></div>
            <div>Tussenvoegsel:<input type="text" name="middle" value="$middle"> </div>
            <div>Achternaam:<input type="text" name="last" value="$last"></div>
            <input type="hidden" name="action" value="update">
            <input type="hidden" name="id" value="$id">   
            <div><input type="submit" name="submit" value="update"></div>
        </form>
    </div>
HTML;
    }
    return $result;
}

function showUserAddHTML($a) {
    $result = null;
    // heredoc syntax in PHP
if($a == 'add') {
$result = <<< HTML
    <div>
        <form action="index.php" method="post">
            <div>Voornaam:<input type="text" name="first"></div>
            <div>Tussenvoegsel:<input type="text" name="middle"></div>
            <div>Achternaam:<input type="text" name="last"></div>
            <input type="hidden" name="action" value="add">
            <div><input type="submit" name="submit" value="voeg toe"></div>
        </form>
    </div>
HTML;
}
return $result;
}

function addUser($f,$m,$l) {
    $result = false;
    $conn = connectDB();
    $sql = "INSERT INTO `user` (`id`,`last`,`middle`,`first`) VALUES (null,?,?,?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sss",$l,$m,$f);
    $result = $stmt->execute();
    return $result;
}


function getUsersHTML () {

    $conn = connectDB();
    $sql = "SELECT `id`,`last`,`middle`,`first`,`doshow` FROM `user`";
    $stmt =  $conn->prepare($sql);
    $stmt->execute();
    $result = $stmt->get_result();

    $html_string = "";

    if($result->num_rows>0) {
        // hier tabel maken
        $html_string .= '<div class="table">';
        while($datarow = $result->fetch_assoc()) {

            if($datarow['doshow'] == 1) {
                // hier tabel vullen met rijen
                $html_string .= "<div class=\"row\">";
                //$html_string .= "<div class=\"cell\">" . $datarow['id'] . "</div>";
                $html_string .= sprintf("<div class=\"cell\"><a onclick=\"return confirm('Are you sure??');\" href='index.php?action=delete&id=%s'><i class=\"fas fa-trash\"></i></a></div>",$datarow['id']);
                $html_string .= sprintf("<div class=\"cell\"><a href='index.php?action=update&id=%s'><i class=\"fas fa-edit\"></i></a></div>",$datarow['id']);
                $html_string .= sprintf("<div class=\"cell\">%s</div>",$datarow['first']);
                $html_string .= "<div class=\"cell\">" . $datarow['middle'] . "</div>";
                $html_string .= "<div class=\"cell\">" . $datarow['last'] . "</div>";

                $html_string .= "</div>";
            }

        }
        // afsluiten tabel
        $html_string .= '</div>';


        return $html_string;

    } else {
        return "No users in database";
    }

}


function deleteUser($id) {
    $result = false;
    $conn = connectDB();
    $sql = "UPDATE `user` SET `doshow` = 0 WHERE `id` = ?";
    $stmt =  $conn->prepare($sql);
    $stmt->bind_param("i",$id);
    $result = $stmt->execute();

    return $result;
}
