<?php
    if(isset($_POST["Submit"]) && $_POST["Submit"] == "注册")
    {
        $user = $_POST["username"];
        $psw = $_POST["password"];
        $psw_confirm = $_POST["confirm"];
        if($user == "" || $psw == "" || $psw_confirm == "")
        {
            echo "<script>alert('请确认信息完整性！'); history.go(-1);</script>";
        }
        else
        {
            if($psw == $psw_confirm)
            {
                $mysql_server_name = "127.0.0.1";
                $mysql_username = "root";
                $mysql_password = "sunshine0712!";
                $mysql_database = "vt";
            
                $pdo = new PDO("mysql:host=".$mysql_server_name.";dbname=".$mysql_database ,$mysql_username, $mysql_password);
            
                $statement = $pdo->query("SELECT * FROM user WHERE username = '$user' ");
            
                $row = $statement->fetch(PDO::FETCH_ASSOC);
                if($row)    //如果已经存在该用户
                {
                    echo "<script>alert('用户名已存在'); history.go(-1);</script>";
                }
                else    //不存在当前注册用户名称
                {
                    
                    if (!preg_match("/^[\x{4e00}-\x{9fa5}a-zA-Z0-9]+$/u",$user))
                    {
                        echo"<script>alert('用户名不合法！');history.go(-1);</script>";
                    }
                    if (strlen($psw)<7 || strlen($psw)>36) 
                    {
                        echo"<script>alert('密码长度不符合要求！'); history.go(-1);</script>";
                    }
                    if (preg_match("/^[a-zA-Z]+$/i", $psw)||preg_match("/^[0-9]+$/i", $psw)) 
                    {
                        echo"<script>alert('密码强度过低！'); history.go(-1);</script>";
                    }
                    else
                    {
                        $sql_insert = "insert into user (username,password,phone,address) values('$user','$psw','','')";
                        $res_insert = $pdo->query($sql_insert);
                    //$res_insert = mysql_query($sql_insert);
                    //$num_insert = mysql_num_rows($res_insert);
                        if($res_insert)
                        {
                            
                            echo "注册成功！";
                            include "login.php";
                        }
                        else
                        {
                            echo "<script>alert('系统繁忙，请稍候！'); history.go(-1);</script>";
                        }
                    }
                }
            }
            else
            {
                echo "<script>alert('密码不一致！'); history.go(-1);</script>";
            }
        
        }
    }
    else
    {
        echo "<script>alert('提交未成功！'); history.go(-1);</script>";
    }
?>
