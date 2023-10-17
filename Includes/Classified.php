    <?php
    class Classified{
        private $userTable = "users";
        private $adsTable = "ads";
        private $requestTable = "requests";
        private $conn;

        public function __construct(){
            $db = new DatabaseConnection;
            $this->conn = $db->conn;
        }

        public function getAds($key, $filter){
            $key = $this->conn->real_escape_string($key);
            $filter = $this->conn->real_escape_string($filter);

            if($key == NULL && $filter == NULL){
                $sql = "SELECT a.AdID, a.AdName, a.AdDescription, a.AdAuthorID, a.AdPicture, a.AdCategory, u.UserID, u.UserName
                        FROM " . $this->adsTable . " as a, ". $this->userTable . " as u
                        WHERE a.AdAuthorID = u.UserID
                        ORDER BY a.AdID DESC ";
                $stmt = $this->conn->prepare($sql);
                $stmt->execute();
                $result = $stmt->get_result();
                return $result;
            }elseif($key== NULL){
                $sql = "SELECT DISTINCT a.AdID, a.AdName, a.AdDescription, a.AdAuthorID, a.AdPicture, a.AdCategory, u.UserID, u.UserName
                FROM " . $this->adsTable . " as a, " . $this->userTable . " as u
                WHERE a.AdCategory LIKE ?
                AND a.AdAuthorID = u.UserID
                ORDER BY a.AdID DESC ";

                    $stmt = $this->conn->prepare($sql);
                    $category = "%$filter%";
                    $stmt->bind_param("s", $category);
                    
                    $stmt->execute();
                    $result = $stmt->get_result();
                    return $result;
            }elseif($filter== NULL){
                $sql = "SELECT DISTINCT a.AdID, a.AdName, a.AdDescription, a.AdAuthorID, a.AdPicture, a.AdCategory, u.UserID, u.UserName
                FROM " . $this->adsTable . " as a, " . $this->userTable . " as u
                WHERE (a.AdName LIKE ? OR a.AdDescription LIKE ? OR u.UserName LIKE ?)
                AND a.AdAuthorID = u.UserID
                ORDER BY a.AdID DESC ";

                    $stmt = $this->conn->prepare($sql);
                    $param = "%$key%";
                    $stmt->bind_param("sss", $param, $param, $param);
                    
                    $stmt->execute();
                    $result = $stmt->get_result();
                    return $result;
            }else{
                $sql = "SELECT DISTINCT a.AdID, a.AdName, a.AdDescription, a.AdAuthorID, a.AdPicture, a.AdCategory, u.UserID, u.UserName
                FROM " . $this->adsTable . " as a, " . $this->userTable . " as u
                WHERE (a.AdName LIKE ? OR a.AdDescription LIKE ? OR u.UserName LIKE ?)
                AND a.AdCategory LIKE ?
                AND a.AdAuthorID = u.UserID
                ORDER BY a.AdID DESC ";

                    $stmt = $this->conn->prepare($sql);
                    $param = "%$key%";
                    $category = "%$filter%";
                    $stmt->bind_param("ssss", $param, $param, $param, $category);
                    
                    $stmt->execute();
                    $result = $stmt->get_result();
                    return $result;
            }
        }
    }

    ?>