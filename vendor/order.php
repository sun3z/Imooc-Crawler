<?php  
  //数据库信息
  $mysql_server_name="mysql56.rdsmn0cf9sv6qb9.rds.bj.baidubce.com"; //数据库服务器名称
  $mysql_username="hweyrqq"; // 连接数据库用户名
  $mysql_password="agtwe_o1fqaq"; // 连接数据库密码
  $mysql_database="mjshop"; // 数据库的名字
  // 连接到数据库
  $conn=mysql_connect($mysql_server_name, $mysql_username,$mysql_password);
  if (!$conn)
    {
      die('Could not connect: ' . mysql_error());
    }
  //解决数据库数据中文乱码的问题
  mysql_query('SET NAMES UTF8');
  // 从表中提取信息的sql语句
  $strsql="SELECT COUNT(orderid) FROM wx_order WHERE TO_DAYS(order_time) = TO_DAYS(NOW())";
  $sql="SELECT SUM(total_money) FROM wx_order WHERE TO_DAYS(order_time) = TO_DAYS(NOW())";
  // $strsql="SELECT orderid,total_money,spname,express,name,tel,province,city,area,address,sku,order_time FROM `wx_order`";
  // 执行sql查询
  $result=mysql_db_query($mysql_database, $strsql, $conn);
  $result1=mysql_db_query($mysql_database, $sql, $conn);

  // var_dump($result);
  // 获取查询结果
  $row=mysql_fetch_row($result);
  $row1=mysql_fetch_row($result1);

  ?>
  <!DOCTYPE html>
  <html>
  <head>
    <meta charset="utf-8">
    <title>今日订单数</title>
  </head>
  <body>
    
    <div style="width:100%;height: 1080px;border: 1px solid rgb(135,140,134);background: rgba(4, 18, 27, 0.88);color: rgb(240,239,220);margin: auto">
      <div style=";margin-top: 10%;width:100%;font-size:40px;text-align: center;color: #5cb85c">
        今日订单
      </div>
      <div style="width: 30%;height: 60px;font-size: 30px;margin:auto;margin-top:100px;text-align:center;border-bottom: solid 1px #4cae4c">
        总单数：<?php echo $row[0]; ?>
      </div>
      <div style="width: 30%;height: 60px;font-size: 30px;margin:auto;margin-top:100px;text-align:center;border-bottom: solid 1px #4cae4c">
        总金额：<?php echo $row1[0]; ?>
      </div>
    </div>
  </body>
  </html>