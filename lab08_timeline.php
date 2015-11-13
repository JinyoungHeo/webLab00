<?php
    class TimeLine {
        # Ex 2 : Fill out the methods
        private $db;
        function __construct()
        {
            # You can change mysql username or password
            $this->db = new PDO("mysql:host=localhost;dbname=timeline", "root", "root");
            $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }
        public function add($tweet) // This function inserts a tweet
        {
            $stmt =$this->db->prepare("INSERT INTO tweets(author, contents, time) VALUES (:author, :contents, now());");
            $stmt->bindParam(':author', $tweet[0]);
            $stmt->bindParam(':contents', $tweet[1]);
            $stmt->execute();
        }
        public function delete($no) // This function deletes a tweet
        {
            $stmt =$this->db->prepare("DELETE FROM tweets WHERE no=:no");
            $stmt->bindParam(':no', $no);
            $stmt->execute();
        }
        # Ex 6: hash tag
        # Find has tag from the contents, add <a> tag using preg_replace() or preg_replace_callback()
        public function loadTweets() // This function load all tweets
        {
            $stmt = $this->db->query("SELECT * FROM tweets ORDER BY time DESC");
            $num_of_row =$stmt->rowCount();
            $stmt = $stmt->fetchAll();

            for ($i =0; $i <$num_of_row; ++$i) {
                $content =$stmt[$i]["contents"];
                $replace = "<a href=\"index.php?select=contents&text=%23$1\">#$1</a>";
                $content =preg_replace("/#([_]*[a-zA-Z0-9]+[\w]*)/", $replace, $content);
                $stmt[$i]["contents"] =$content;
            }
            return $stmt;
        }
        public function searchTweets($type, $query) // This function load tweets meeting conditions
        {
            $stmt =$this->db->prepare("SELECT * FROM tweets WHERE $type LIKE :query ORDER BY time DESC");
            $query_include_percent ="%$query%";
            $stmt->bindParam(':query', $query_include_percent);
            $stmt->execute();
            $num_of_row =$stmt->rowCount();
            $stmt = $stmt->fetchAll();

            for ($i =0; $i <$num_of_row; ++$i) {
                $content =$stmt[$i]["contents"];
                $replace = "<a href=\"index.php?select=contents&text=%23$1\">#$1</a>";
                $content =preg_replace("/#([_]*[a-zA-Z0-9]+[\w]*)/", $replace, $content);
                $stmt[$i]["contents"] =$content;
            }
            return $stmt; 
        }
    }
?>
