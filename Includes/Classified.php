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
                $sql = "SELECT a.AdID, a.AdName, a.AdDescription, a.AdAuthorID, a.AdPicture, a.AdCategory, a.AdPostedDateTime, u.UserID, u.UserName
                        FROM " . $this->adsTable . " as a, ". $this->userTable . " as u
                        WHERE a.AdAuthorID = u.UserID
                        ORDER BY a.AdID DESC ";
                $stmt = $this->conn->prepare($sql);
                $stmt->execute();
                $result = $stmt->get_result();
                return $result;
            }else{
                $sql = "SELECT DISTINCT a.AdID, a.AdName, a.AdDescription, a.AdAuthorID, a.AdPicture, a.AdCategory, a.AdPostedDateTime, u.UserID, u.UserName
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

        public function getCategories() {
            // Determine the maximum number of words in any category
            $sqlMaxWords = "SELECT MAX(LENGTH(AdCategory) - LENGTH(REPLACE(AdCategory, ' ', '')) + 1) AS max_words FROM ads";
            $stmtMaxWords = $this->conn->prepare($sqlMaxWords);
            $stmtMaxWords->execute();
            $resultMaxWords = $stmtMaxWords->get_result();
            $maxWords = $resultMaxWords->fetch_assoc()["max_words"];
        
            // Generate the dynamic subquery for extracting unique words
            $subquery = "";
            for ($i = 1; $i <= $maxWords; $i++) {
                $subquery .= "SELECT SUBSTRING_INDEX(SUBSTRING_INDEX(AdCategory, ' ', $i), ' ', -1) AS word FROM ads";
                if ($i < $maxWords) {
                    $subquery .= " UNION ALL ";
                }
            }
        
            // Construct the final SQL query
            $sql = "SELECT word AS Category
                    FROM ($subquery) subquery
                    WHERE word IS NOT NULL AND word != ''
                    GROUP BY word
                    ORDER BY word";
        
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            $result = $stmt->get_result();
            return $result;
        }
        
    }

    ?>