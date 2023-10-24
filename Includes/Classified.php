    <?php
    class Classified
    {
        private $userTable = "users";
        private $adsTable = "ads";
        private $requestTable = "requests";
        private $conn;

        public function __construct()
        {
            $db = new DatabaseConnection;
            $this->conn = $db->conn;
        }

        public function getAds($key, $filter, $stat, $UserID){
            $key = $this->conn->real_escape_string($key);
            $status = "%$stat%";

            if($key == NULL && $filter == NULL && $UserID == NULL && $stat == NULL){
                $sql = "SELECT a.AdID, a.AdName, a.AdDescription, a.Price, a.AdAuthorID, a.AdPicture, a.AdCategory, a.AdPostedDateTime, a.AdStatus, u.UserID, u.UserName
                        FROM " . $this->adsTable . " as a, " . $this->userTable . " as u
                        WHERE a.AdAuthorID = u.UserID
                        ORDER BY a.AdID DESC ";
                $stmt = $this->conn->prepare($sql);
                $stmt->execute();
                $result = $stmt->get_result();
                return $result;
            }elseif($key == NULL && $filter == NULL && $UserID == NULL){
                $sql = "SELECT a.AdID, a.AdName, a.AdDescription, a.Price, a.AdAuthorID, a.AdPicture, a.AdCategory, a.AdPostedDateTime, a.AdStatus, u.UserID, u.UserName
                        FROM " . $this->adsTable . " as a, " . $this->userTable . " as u
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
            }elseif($key!= NULL && $filter == NULL && $UserID != NULL){
                $sql = "SELECT a.AdID, a.AdName, a.AdDescription, a.Price, a.AdAuthorID, a.AdPicture, a.AdCategory, a.AdPostedDateTime, a.AdStatus, u.UserID, u.UserName
                        FROM " . $this->adsTable . " as a, ". $this->userTable . " as u
                        WHERE (a.AdName LIKE ? OR a.AdDescription LIKE ? OR u.UserName LIKE ?)
                        AND a.AdAuthorID = u.UserID
                        AND a.AdStatus LIKE ?
                        AND a.AdAuthorID = ?
                        ORDER BY a.AdID DESC ";

                $param = "%$key%";
                $stmt = $this->conn->prepare($sql);
                $stmt->bind_param("ssssi", $param, $param, $param, $status, $UserID);
                $stmt->execute();
                $result = $stmt->get_result();
                return $result;
            }elseif($key!= NULL && $filter == NULL && $stat != NULL ){
                
                $sql = "SELECT a.AdID, a.AdName, a.AdDescription, a.Price, a.AdAuthorID, a.AdPicture, a.AdCategory, a.AdPostedDateTime, a.AdStatus, u.UserID, u.UserName
                FROM " . $this->adsTable . " as a, ". $this->userTable . " as u
                WHERE (a.AdName LIKE ? OR a.AdDescription LIKE ? OR u.UserName LIKE ?)
                AND a.AdAuthorID = u.UserID
                AND a.AdStatus LIKE ?
                ORDER BY a.AdID DESC ";

                $param = "%$key%";
                $stmt = $this->conn->prepare($sql);
                $stmt->bind_param("ssss", $param, $param, $param, $status);
                $stmt->execute();
                $result = $stmt->get_result();
                return $result;
            }elseif($key!= NULL && $filter == NULL && $stat == NULL ){
                
                $sql = "SELECT a.AdID, a.AdName, a.AdDescription, a.Price, a.AdAuthorID, a.AdPicture, a.AdCategory, a.AdPostedDateTime, a.AdStatus, u.UserID, u.UserName
                FROM " . $this->adsTable . " as a, ". $this->userTable . " as u
                WHERE (a.AdName LIKE ? OR a.AdDescription LIKE ? OR u.UserName LIKE ?)
                AND a.AdAuthorID = u.UserID
                ORDER BY a.AdID DESC ";

                $param = "%$key%";
                $stmt = $this->conn->prepare($sql);
                $stmt->bind_param("sss", $param, $param, $param);
                $stmt->execute();
                $result = $stmt->get_result();
                return $result;
            }else{
                $filter = explode(" ", $filter);
                $categoryConditions = [];
                foreach ($filter as $category) {
                    $categoryConditions[] = "FIND_IN_SET(?, a.AdCategory) > 0";
                }
            
                $categoryCondition = implode(' OR ', $categoryConditions);
        
                $sql = "SELECT DISTINCT a.AdID, a.AdName, a.AdDescription, a.Price, a.AdAuthorID, a.AdPicture, a.AdCategory, a.AdPostedDateTime, a.AdStatus, u.UserID, u.UserName
                        FROM " . $this->adsTable . " as a, " . $this->userTable . " as u
                        WHERE (a.AdName LIKE ? OR a.AdDescription LIKE ? OR u.UserName LIKE ?)
                        AND a.AdStatus LIKE ?
                        AND a.AdAuthorID = u.UserID
                        AND ($categoryCondition)
                        ORDER BY a.AdID DESC ";
                        $param = "%$key%";
                
                $stmt = $this->conn->prepare($sql);
                $stmt->bind_param(str_repeat('s', count($filter) + 4), $param, $param, $param, $status, ...$filter);
                $stmt->execute();
                $result = $stmt->get_result();
                return $result;
                
            }
        }

        public function getCategories()
        {
            // Determine the maximum number of words in any category
            $sqlMaxWords = "SELECT MAX(LENGTH(AdCategory) - LENGTH(REPLACE(AdCategory, ',', '')) + 1) AS max_words FROM ads";
            $stmtMaxWords = $this->conn->prepare($sqlMaxWords);
            $stmtMaxWords->execute();
            $resultMaxWords = $stmtMaxWords->get_result();
            $maxWords = $resultMaxWords->fetch_assoc()["max_words"];

            // Generate the dynamic subquery for extracting unique words
            $subquery = "";
            for ($i = 1; $i <= $maxWords; $i++) {
                $subquery .= "SELECT SUBSTRING_INDEX(SUBSTRING_INDEX(AdCategory, ',', $i), ',', -1) AS word FROM ads";
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

        public function getStatus(){
        
        $sql = "SELECT distinct AdStatus from ads";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $result = $stmt->get_result();

        $selectedStatus = array();
        if(isset($_GET['status'])){
            $selectedStatus = $_GET['status'];
        }
        return array('result' => $result, 'selectedStatus' => $selectedStatus);
        }




        public function deleteAd($AdID)
        {
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