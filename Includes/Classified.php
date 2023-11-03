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
            $status = $stat;

            if($key == NULL && $filter == NULL && $UserID == NULL && $stat == NULL){
                //Constructor Method
                $sql = "SELECT a.AdID, a.AdName, a.AdDescription, a.Price, a.AdAuthorID, a.AdPicture, a.AdCategory, a.AdPostedDateTime,a.AdPaymentPicture, a.AdStatus, u.UserID, u.UserName
                        FROM " . $this->adsTable . " as a, " . $this->userTable . " as u
                        WHERE a.AdAuthorID = u.UserID
                        ORDER BY a.AdID DESC ";
                $stmt = $this->conn->prepare($sql);
                $stmt->execute();
                $result = $stmt->get_result();
                return $result;
            }elseif($key == NULL && $filter == NULL && $UserID == NULL){
                //Main Page without search and category (included with Approved) / Request Page without search and category but has status
                $sql = "SELECT a.AdID, a.AdName, a.AdDescription, a.Price, a.AdAuthorID, a.AdPicture, a.AdCategory, a.AdPostedDateTime,a.AdPaymentPicture, a.AdStatus, u.UserID, u.UserName
                        FROM " . $this->adsTable . " as a, " . $this->userTable . " as u
                        WHERE a.AdAuthorID = u.UserID
                        AND AdStatus IN (" . str_repeat('?, ', count($status) - 1) . '?)' . "
                        ORDER BY a.AdID DESC ";
                $stmt = $this->conn->prepare($sql);
                $stmt->bind_param(str_repeat('s', count($status)), ...$status);
                $stmt->execute();
                $result = $stmt->get_result();
                return $result;
            }elseif($key == NULL && $filter == NULL && $status == NULL && $UserID != NULL){
                //History Page without search
                $sql = "SELECT a.AdID, a.AdName, a.AdDescription, a.Price, a.AdAuthorID, a.AdPicture, a.AdCategory, a.AdPostedDateTime,a.AdPaymentPicture, a.AdStatus, u.UserID, u.UserName
                        FROM " . $this->adsTable . " as a, ". $this->userTable . " as u
                        WHERE a.AdAuthorID = u.UserID
                        AND a.AdAuthorID = ?
                        ORDER BY a.AdID DESC ";
                $stmt = $this->conn->prepare($sql);
                $stmt->bind_param("i", $UserID);
                $stmt->execute();
                $result = $stmt->get_result();
                return $result;
            }elseif($key!= NULL && $filter == NULL && $status == NULL && $UserID != NULL){
                //History page with serch
                $sql = "SELECT a.AdID, a.AdName, a.AdDescription, a.Price, a.AdAuthorID, a.AdPicture, a.AdCategory, a.AdPostedDateTime, a.AdStatus, u.UserID, u.UserName
                        FROM " . $this->adsTable . " as a, ". $this->userTable . " as u
                        WHERE (a.AdName LIKE ? OR a.AdDescription LIKE ? OR u.UserName LIKE ?)
                        AND a.AdAuthorID = u.UserID
                        AND a.AdAuthorID = ?
                        ORDER BY a.AdID DESC ";

                $param = "%$key%";
                $stmt = $this->conn->prepare($sql);
                $stmt->bind_param("sssi", $param, $param, $param, $UserID);
                $stmt->execute();
                $result = $stmt->get_result();
                return $result;
            }elseif($key!= NULL && $filter == NULL && $stat != NULL ){
                //Request page with search and status, but without category / Main page with search, without category
                $sql = "SELECT a.AdID, a.AdName, a.AdDescription, a.Price, a.AdAuthorID, a.AdPicture, a.AdCategory, a.AdPostedDateTime,a.AdPaymentPicture, a.AdStatus, u.UserID, u.UserName
                FROM " . $this->adsTable . " as a, ". $this->userTable . " as u
                WHERE (a.AdName LIKE ? OR a.AdDescription LIKE ? OR u.UserName LIKE ?)
                AND a.AdAuthorID = u.UserID
                AND AdStatus IN (" . str_repeat('?, ', count($status) - 1) . '?)' . "
                ORDER BY a.AdID DESC ";

                $param = "%$key%";
                $params = array_merge([$param,$param,$param],$status);
                $stmt = $this->conn->prepare($sql);
                $stmt->bind_param(str_repeat('s', count($status) + 3), ...$params);
                $stmt->execute();
                $result = $stmt->get_result();
                return $result;
            }elseif($key!= NULL && $filter != NULL && $stat == NULL ){
                //Request page with search and category, but without status
                $categoryConditions = [];
                foreach ($filter as $category) {
                    $categoryConditions[] = "FIND_IN_SET(?, a.AdCategory) > 0";
                }
                $categoryCondition = implode(' OR ', $categoryConditions);
                $sql = "SELECT a.AdID, a.AdName, a.AdDescription, a.Price, a.AdAuthorID, a.AdPicture, a.AdCategory, a.AdPostedDateTime,a.AdPaymentPicture, a.AdStatus, u.UserID, u.UserName
                FROM " . $this->adsTable . " as a, ". $this->userTable . " as u
                WHERE (a.AdName LIKE ? OR a.AdDescription LIKE ? OR u.UserName LIKE ?)
                AND a.AdAuthorID = u.UserID
                AND ($categoryCondition)
                ORDER BY a.AdID DESC ";

                $param = "%$key%";
                $params = array_merge([$param,$param,$param],$filter);
                $stmt = $this->conn->prepare($sql);
                $stmt->bind_param(str_repeat('s', count($params)), ...$params);
                $stmt->execute();
                $result = $stmt->get_result();
                return $result;
            }elseif($key== NULL && $filter != NULL && $stat == NULL ){
                //Request page with category, but without search and status 
                $categoryConditions = [];
                foreach ($filter as $category) {
                    $categoryConditions[] = "FIND_IN_SET(?, a.AdCategory) > 0";
                }
                $categoryCondition = implode(' OR ', $categoryConditions);
                $sql = "SELECT a.AdID, a.AdName, a.AdDescription, a.Price, a.AdAuthorID, a.AdPicture, a.AdCategory, a.AdPostedDateTime,a.AdPaymentPicture, a.AdStatus, u.UserID, u.UserName
                FROM " . $this->adsTable . " as a, ". $this->userTable . " as u
                WHERE a.AdAuthorID = u.UserID
                AND ($categoryCondition)
                ORDER BY a.AdID DESC ";

                $stmt = $this->conn->prepare($sql);
                $stmt->bind_param(str_repeat('s', count($filter)), ...$filter);
                $stmt->execute();
                $result = $stmt->get_result();
                return $result;
            }elseif($key!= NULL && $filter == NULL && $stat == NULL && $UserID == NULL){
                //Main page with search without category / Request page with search without category and status
                $sql = "SELECT a.AdID, a.AdName, a.AdDescription, a.Price, a.AdAuthorID, a.AdPicture, a.AdCategory, a.AdPostedDateTime,a.AdPaymentPicture, a.AdStatus, u.UserID, u.UserName
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
                //Request page with search, category, and status
                $categoryConditions = [];
                foreach ($filter as $category) {
                    $categoryConditions[] = "FIND_IN_SET(?, a.AdCategory) > 0";
                }
            
                $categoryCondition = implode(' OR ', $categoryConditions);
        
                $sql = "SELECT DISTINCT a.AdID, a.AdName, a.AdDescription, a.Price, a.AdAuthorID, a.AdPicture, a.AdCategory, a.AdPostedDateTime,a.AdPaymentPicture, a.AdStatus, u.UserID, u.UserName
                        FROM " . $this->adsTable . " as a, " . $this->userTable . " as u
                        WHERE (a.AdName LIKE ? OR a.AdDescription LIKE ? OR u.UserName LIKE ?)
                        AND AdStatus IN (" . str_repeat('?, ', count($status) - 1) . '?)' . "
                        AND a.AdAuthorID = u.UserID
                        AND ($categoryCondition)
                        ORDER BY a.AdID DESC ";
                        $param = "%$key%";
                
                $stmt = $this->conn->prepare($sql);
                $stmt->bind_param(str_repeat('s', count($filter) + 3 + count($status)), $param, $param, $param, ...$status, ...$filter);
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
            $sql = "SELECT DISTINCT AdStatus FROM ads ORDER BY AdStatus ASC"; // Add ORDER BY clause
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            $result = $stmt->get_result();
        
            $selectedStatus = array();
            if(isset($_GET['status'])){
                $selectedStatus = $_GET['status'];
            }
            
            return array('result' => $result, 'selectedStatus' => $selectedStatus);
        }
        


        public function changeStatus($AdID, $status){
            $sqlQuery = "UPDATE ads
            SET AdStatus = ?
            WHERE AdID = ?;";
            $stmt = $this->conn->prepare($sqlQuery);
            $stmt->bind_param("si", $status, $AdID);
            $stmt->execute();
        }
        

        public function setPrice($AdID, $price){
            $sql = "UPDATE ads
            SET Price = ?
            WHERE AdID = ?;";
            $stmt = $this->conn->prepare($sql);
            $stmt->bind_param("di" ,$price, $AdID);
            $stmt->execute();
        }

        public function setPostTimeNOW($AdID){
            $sql = "UPDATE ads
            SET AdPostedDateTime = NOW()
            WHERE AdID = ?;";
            $stmt = $this->conn->prepare($sql);
            $stmt->bind_param("i", $AdID);
            $stmt->execute();
        }

        public function getAuthorName($AdID){
            $sql = "SELECT DISTINCT u.UserName
            FROM users u, ads a
            WHERE a.AdID = ?
            AND a.AdAuthorID = u.UserID;";
            $stmt = $this->conn->prepare($sql);
            $stmt->bind_param("i", $AdID);
            $stmt->execute();
            $result = $stmt->get_result();
            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                return $row['UserName'];
            } else {
                return false;
            }
        }

        public function getAuthorEmail($AdID){
            $sql = "SELECT DISTINCT u.UserEmail
            FROM users u, ads a
            WHERE a.AdID = ?
            AND a.AdAuthorID = u.UserID;";
            $stmt = $this->conn->prepare($sql);
            $stmt->bind_param("i", $AdID);
            $stmt->execute();
            $result = $stmt->get_result();
            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                return $row['UserEmail'];
            } else {
                return false;
            }
        }

        public function getAdName($AdID){
            $sql = "SELECT AdName
            FROM ads
            WHERE AdID = ? ;";
            $stmt = $this->conn->prepare($sql);
            $stmt->bind_param("i", $AdID);
            $stmt->execute();
            $result = $stmt->get_result();
            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                return $row['AdName'];
            } else {
                return false;
            }
        }
    }

    ?>