package com.company;
import java.sql.*;
import java.util.Properties;

public class Main {

    public static Connection getConnection() throws SQLException {

        Connection conn = null;
        Properties connectionProps = new Properties();
        connectionProps.put("user", "beste.guney");
        connectionProps.put("password", "mXGI4qVi");
        connectionProps.put("dbName", "beste_guney");
        System.out.println(connectionProps.getProperty("dbName"));
        String urlDb = "jdbc:mysql://dijkstra.ug.bcc.bilkent.edu.tr:3306/" + connectionProps.getProperty("dbName");
        conn = DriverManager.getConnection(urlDb, connectionProps.getProperty("user"), connectionProps.getProperty("password"));

        System.out.println("Connected to database");
        return conn;
    }


    public static void main(String[] args){
	// write your code here
        Connection conn = null;

        try {
            conn = getConnection();
        } catch (SQLException e) {
           System.out.println("Cannot create the connection");
        }

        Statement statement = null;
        try {
            statement = conn.createStatement();

            //sql statements for creating the tables

            //first if tables exist drop
            String sql = "drop table if exists buy";
            statement.executeUpdate(sql);
            sql = "drop table if exists customer";
            statement.executeUpdate(sql);
            sql = "drop table if exists product";
            statement.executeUpdate(sql);

            //then recreate tables
            sql = "create table customer(cid char(12),cname varchar(50),bdate DATE,address varchar(50),city varchar(20),wallet float ,primary key(cid)) engine=innodb";

            statement.executeUpdate(sql);
            System.out.println("Customers are ready");

            sql = "create table product(" + "pid char(8), pname varchar(20), price float, stock int, " +
                    "primary key(pid))" + "engine=innodb";
            statement.executeUpdate(sql);
            System.out.println("Products are ready");

            sql = "create table buy(" + "cid char(12), pid char(8), quantity int, primary key(cid, pid, quantity)," +
                    "foreign key (cid) references customer(cid) on delete cascade on update cascade," +
                    "foreign key (pid) references product(pid) on delete cascade on update cascade)" + "engine=innodb";
            statement.executeUpdate(sql);
            System.out.println("Relation buy is ready");

            //inserting customers into db
            sql = "insert into customer values('C101', 'Ali', '1997-03-03', 'Besiktas', 'Istanbul', 114.50)";
            statement.executeUpdate(sql);
            sql = "insert into customer values('C102', 'Veli', '2001-05-19', 'Bilkent', 'Ankara', 200.00)";
            statement.executeUpdate(sql);
            sql = "insert into customer values('C103', 'Ayse', '1972-04-23', 'Tunali', 'Ankara', 15.00)";
            statement.executeUpdate(sql);
            sql = "insert into customer values('C104', 'Alice', '1990-10-29', 'Meltem', 'Antalya', 1024.00)";
            statement.executeUpdate(sql);
            sql = "insert into customer values('C105', 'Bob', '1987-08-30', 'Stretford', 'Manchester', 15.00)";
            statement.executeUpdate(sql);
            System.out.println("Customer insertion is ended");

            //inserting products into db
            sql = "insert into product values('P101', 'powerbank', 300.00, 2)";
            statement.executeUpdate(sql);
            sql = "insert into product values('P102', 'battery', 5.50, 5)";
            statement.executeUpdate(sql);
            sql = "insert into product values('P103', 'laptop', 3500.00, 10)";
            statement.executeUpdate(sql);
            sql = "insert into product values('P104', 'mirror', 10.75, 50)";
            statement.executeUpdate(sql);
            sql = "insert into product values('P105', 'notebook', 3.85, 100)";
            statement.executeUpdate(sql);
            sql = "insert into product values('P106', 'carpet', 50.99, 1)";
            statement.executeUpdate(sql);
            sql = "insert into product values('P107', 'lawn mower', 1025.00, 3)";
            statement.executeUpdate(sql);
            System.out.println("Product insertion is ended");

            //inserting buy into db
            sql = "insert into buy values('C101', 'P105', 2)";
            statement.executeUpdate(sql);
            sql = "insert into buy values('C102', 'P105', 2)";
            statement.executeUpdate(sql);
            sql = "insert into buy values('C103', 'P105', 5)";
            statement.executeUpdate(sql);
            sql = "insert into buy values('C101', 'P101', 1)";
            statement.executeUpdate(sql);
            sql = "insert into buy values('C102', 'P102', 4)";
            statement.executeUpdate(sql);
            sql = "insert into buy values('C105', 'P104', 1)";
            statement.executeUpdate(sql);
            System.out.println("Buy insertion is ended");
            //sql printing statements

            ResultSet set = null;
            String sql1 = "select bdate, address,city from customer where wallet = (select min(wallet) from customer)";

            set = statement.executeQuery(sql1);
            while(set.next()){
                System.out.print(set.getString("bdate") + "," + set.getString("address") + "," + set.getString("city"));
                System.out.println();
            }

            /*String sql2 = "select customer.cname as customer_name from customer where not exists ((select pid from product where price < 10) except (select pid from buy where buy.cid = customer.cid))";
            set = statement.executeQuery(sql2);
            while(set.next()){
                System.out.print(set.getString("customer_name"));
                System.out.println();
            }*/

            String sql3 = "select product.pname from product, (select buy.pid from buy group by pid having count(DISTINCT cid) > 2) as T where product.pid = T.pid";
            set = statement.executeQuery(sql3);
            while(set.next()){
                System.out.print(set.getString("pname"));
                System.out.println();
            }


            String sql4 = "select pname from product where price < (select C.wallet from (select max(extract(year from bdate)) as age from customer) as T, customer C where T.age = extract(year from C.bdate))";
            set = statement.executeQuery(sql4);
            while(set.next()){
                System.out.print(set.getString("pname"));
                System.out.println();
            }

            String sql5 = "select customer.cname from (select buy.cid, sum(quantity*price) as qua from buy, product where buy.pid=product.pid group by cid) as T, customer where customer.cid= T.cid and qua = (select max(qua) from (select buy.cid, sum(quantity*price) as qua from buy, product where buy.pid=product.pid group by cid) as P)";
            set = statement.executeQuery(sql5);
            while(set.next()){
                System.out.print(set.getString("cname"));
                System.out.println();
            }
        } catch (SQLException e) {
            e.printStackTrace();
            System.out.println("Statement could not created");
        }

    }
}
