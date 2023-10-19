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

        public function getAds($key, $filter, $stat, $UserID){
            $key = $this->conn->real_escape_string($key);
            $filter = $this->conn->real_escape_string($filter);
            $status = "%$stat%";

            if($key == NULL && $filter == NULL && $UserID == NULL){
                $sql = "SELECT a.AdID, a.AdName, a.AdDescription, a.Price, a.AdAuthorID, a.AdPicture, a.AdCategory, a.AdPostedDateTime, a.AdStatus, u.UserID, u.UserName
                        FROM " . $this->adsTable . " as a, ". $this->userTable . " as u
                        WHERE a.AdAuthorID = u.UserID
                        AND a.AdStatus LIKE ?
                        ORDER BY a.AdID DESC ";
                $stmt = $this->conn->prepare($sql);
                $stmt->bind_param("s", $status);
                $stmt->execute();
                $result = $stmt->get_result();
                return $result;
            }elseif($key == NULL && $filter == NULL && $UserID != NULL){
                $sql = "SELECT a.AdID, a.AdName, a.AdDescription, a.Price, a.AdAuthorID, a.AdPicture, a.AdCategory, a.AdPostedDateTime, a.AdStatus, u.UserID, u.UserName
                        FROM " . $this->adsTable . " as a, ". $this->userTable . " as u
                        WHERE a.AdAuthorID = u.UserID
                        AND a.AdStatus LIKE ?
                        AND a.AdAuthorID = ?
                        ORDER BY a.AdID DESC ";
                $stmt = $this->conn->prepare($sql);
                $stmt->bind_param("si", $status, $UserID);
                $stmt->execute();
                $result = $stmt->get_result();
                return $result;
            }else{
                $sql = "SELECT DISTINCT a.AdID, a.AdName, a.AdDescription, a.Price, a.AdAuthorID, a.AdPicture, a.AdCategory, a.AdPostedDateTime, a.AdStatus, u.UserID, u.UserName
                FROM " . $this->adsTable . " as a, " . $this->userTable . " as u
                WHERE (a.AdName LIKE ? OR a.AdDescription LIKE ? OR u.UserName LIKE ?)
                AND a.AdCategory LIKE ?
                AND a.AdStatus LIKE ?
                AND a.AdAuthorID = u.UserID
                ORDER BY a.AdID DESC ";

                    $stmt = $this->conn->prepare($sql);
                    $param = "%$key%";
                    $category = "%$filter%";
                    $stmt->bind_param("sssss", $param, $param, $param, $category, $status);
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

            $selectedCategories = array();
            if (isset($_GET['category'])) {
                $selectedCategories = $_GET['category'];
            }
        
            return array('result' => $result, 'selectedCategories' => $selectedCategories);
        }

        public function deleteAd($AdID){
            $sqlQuery = "DELETE FROM " . $this->adsTable . " WHERE AdID = ?";
		    $stmt = $this->conn->prepare($sqlQuery);
		    $stmt->bind_param("i", $AdID);
		    $stmt->execute();
        }

        public function changeStatus($AdID, $status){
            $sqlQuery = "UPDATE ads
            SET AdStatus = ?
            WHERE AdID = ?;";
            $stmt = $this->conn->prepare($sqlQuery);
            $stmt->bind_param("si", $status, $AdID);
            $stmt->execute();
        }
        
    }

    ?>