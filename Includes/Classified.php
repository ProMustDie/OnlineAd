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
                        ORDER BY a.AdID DESC
                        LIMIT ".$this->offset.", ".$this->total_ads_per_page."";
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
                        ORDER BY a.AdID DESC
                        LIMIT ".$this->offset.", ".$this->total_ads_per_page."";
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
                        ORDER BY a.AdID DESC
                        LIMIT ".$this->offset.", ".$this->total_ads_per_page."";
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
                        ORDER BY a.AdID DESC
                        LIMIT ".$this->offset.", ".$this->total_ads_per_page."";

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
                ORDER BY a.AdID DESC
                LIMIT ".$this->offset.", ".$this->total_ads_per_page."";

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
                ORDER BY a.AdID DESC
                LIMIT ".$this->offset.", ".$this->total_ads_per_page."";

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
                ORDER BY a.AdID DESC
                LIMIT ".$this->offset.", ".$this->total_ads_per_page."";

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
                ORDER BY a.AdID DESC
                LIMIT ".$this->offset.", ".$this->total_ads_per_page."";

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
                        ORDER BY a.AdID DESC
                        LIMIT ".$this->offset.", ".$this->total_ads_per_page."";
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
    // Determine the maximum number of words in any category for AdID=1
    $sqlMaxWords = "SELECT MAX(LENGTH(AdCategory) - LENGTH(REPLACE(AdCategory, ',', '')) + 1) AS max_words FROM ads WHERE AdID = 1";
    $stmtMaxWords = $this->conn->prepare($sqlMaxWords);
    $stmtMaxWords->execute();
    $resultMaxWords = $stmtMaxWords->get_result();
    $maxWords = $resultMaxWords->fetch_assoc()["max_words"];

    // Generate the dynamic subquery for extracting unique words for AdID=1
    $subquery = "";
    for ($i = 1; $i <= $maxWords; $i++) {
        $subquery .= "SELECT SUBSTRING_INDEX(SUBSTRING_INDEX(AdCategory, ',', $i), ',', -1) AS word FROM ads WHERE AdID = 1";
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

        public function setTimeNOW($AdID, $Column){
            $sql = "UPDATE ads
            SET $Column = NOW()
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

        public function getUsersList($currentID) {
            $sqlQuery = "
                SELECT u.UserName, u.UserID, u.UserEmail
                FROM " . $this->userTable . " as u
                WHERE u.UserID != '$currentID'
                ORDER BY u.UserName ASC";
                
            $stmt = $this->conn->prepare($sqlQuery);
            $stmt->execute();
            $result = $stmt->get_result();
            
            return $result;
        }

        public function getusertype($userID){
            $getType_query = "SELECT UserType FROM users WHERE UserID = ?";
    
            $stmt = $this->conn->prepare($getType_query);
            $stmt->bind_param("i", $userID);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                $type = $row['UserType'];
                return $type;
            } else {
                return NULL;
            }
        }

        public function catIsDuplicate($category){
            $dupli_query ="SELECT AdCategory FROM ads WHERE AdID = 1";
            $stmt = $this->conn->prepare($dupli_query);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                $categories = array_map('strtolower', explode(',', $row['AdCategory']));
                $provided_category = strtolower($category);

                if (in_array($provided_category, $categories)) {
                    return true;
                } else {
                    return false;
                }
            } else {
                return false;
            }
        }

        public function addCategory($category){
            $addCat_query = "UPDATE ads SET AdCategory = CONCAT(AdCategory, ?) WHERE AdID = 1";
            $stmt = $this->conn->prepare($addCat_query);
            $category = ",".$category;
            $stmt->bind_param("s", $category);
            $result = $stmt->execute();
            return $result;
        }

        public function delCategory($category){
            $getCat_query = "SELECT AdCategory FROM ads WHERE AdID = 1";
            $stmt = $this->conn->prepare($getCat_query);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                $fetchedCat = $row['AdCategory'];
                $catArray = explode(',', $fetchedCat);
                $updatedCatArray = array_diff($catArray, array($category));
                $updatedCat = implode(',', $updatedCatArray); 

                $delCat_query = "UPDATE ads SET AdCategory = '$updatedCat' WHERE AdID = 1";
                $stmt = $this->conn->prepare($delCat_query);
                $result = $stmt->execute();
                return $result;
            } else {
                return false;
            }   
        }

        public function updateAd($AdID, $title, $desc, $status, $categories){
            $updateAd_query = "UPDATE ads SET AdName = ?, AdDescription = ?, AdStatus = ?, AdCategory = ? WHERE AdID = ?";
            $stmt = $this->conn->prepare($updateAd_query);
            $stmt->bind_param("ssssi", $title, $desc, $status, $categories, $AdID);
            $result = $stmt->execute();
            echo $stmt->error;
            return $result;
        }

        public function getTotalAds($key, $filter, $stat, $UserID){
            $key = $this->conn->real_escape_string($key);
            $status = $stat;

            if($key == NULL && $filter == NULL && $UserID == NULL && $stat == NULL){
                //Constructor Method
                $sql = "SELECT COUNT(a.AdID) as total_ads, a.AdName, a.AdDescription, a.Price, a.AdAuthorID, a.AdPicture, a.AdCategory, a.AdPostedDateTime,a.AdPaymentPicture, a.AdStatus, u.UserID, u.UserName
                        FROM " . $this->adsTable . " as a, " . $this->userTable . " as u
                        WHERE a.AdAuthorID = u.UserID
                        ORDER BY a.AdID DESC";
                $stmt = $this->conn->prepare($sql);
                $stmt->execute();
                $result = $stmt->get_result();
                
            }elseif($key == NULL && $filter == NULL && $UserID == NULL){
                //Main Page without search and category (included with Approved) / Request Page without search and category but has status
                $sql = "SELECT COUNT(a.AdID) as total_ads, a.AdName, a.AdDescription, a.Price, a.AdAuthorID, a.AdPicture, a.AdCategory, a.AdPostedDateTime,a.AdPaymentPicture, a.AdStatus, u.UserID, u.UserName
                        FROM " . $this->adsTable . " as a, " . $this->userTable . " as u
                        WHERE a.AdAuthorID = u.UserID
                        AND AdStatus IN (" . str_repeat('?, ', count($status) - 1) . '?)' . "
                        ORDER BY a.AdID DESC";
                $stmt = $this->conn->prepare($sql);
                $stmt->bind_param(str_repeat('s', count($status)), ...$status);
                $stmt->execute();
                $result = $stmt->get_result();
                
            }elseif($key == NULL && $filter == NULL && $status == NULL && $UserID != NULL){
                //History Page without search
                $sql = "SELECT COUNT(a.AdID) as total_ads, a.AdName, a.AdDescription, a.Price, a.AdAuthorID, a.AdPicture, a.AdCategory, a.AdPostedDateTime,a.AdPaymentPicture, a.AdStatus, u.UserID, u.UserName
                        FROM " . $this->adsTable . " as a, ". $this->userTable . " as u
                        WHERE a.AdAuthorID = u.UserID
                        AND a.AdAuthorID = ?
                        ORDER BY a.AdID DESC";
                $stmt = $this->conn->prepare($sql);
                $stmt->bind_param("i", $UserID);
                $stmt->execute();
                $result = $stmt->get_result();
                
            }elseif($key!= NULL && $filter == NULL && $status == NULL && $UserID != NULL){
                //History page with serch
                $sql = "SELECT COUNT(a.AdID) as total_ads, a.AdName, a.AdDescription, a.Price, a.AdAuthorID, a.AdPicture, a.AdCategory, a.AdPostedDateTime, a.AdStatus, u.UserID, u.UserName
                        FROM " . $this->adsTable . " as a, ". $this->userTable . " as u
                        WHERE (a.AdName LIKE ? OR a.AdDescription LIKE ? OR u.UserName LIKE ?)
                        AND a.AdAuthorID = u.UserID
                        AND a.AdAuthorID = ?
                        ORDER BY a.AdID DESC";

                $param = "%$key%";
                $stmt = $this->conn->prepare($sql);
                $stmt->bind_param("sssi", $param, $param, $param, $UserID);
                $stmt->execute();
                $result = $stmt->get_result();
                
            }elseif($key!= NULL && $filter == NULL && $stat != NULL ){
                //Request page with search and status, but without category / Main page with search, without category
                $sql = "SELECT COUNT(a.AdID) as total_ads, a.AdName, a.AdDescription, a.Price, a.AdAuthorID, a.AdPicture, a.AdCategory, a.AdPostedDateTime,a.AdPaymentPicture, a.AdStatus, u.UserID, u.UserName
                FROM " . $this->adsTable . " as a, ". $this->userTable . " as u
                WHERE (a.AdName LIKE ? OR a.AdDescription LIKE ? OR u.UserName LIKE ?)
                AND a.AdAuthorID = u.UserID
                AND AdStatus IN (" . str_repeat('?, ', count($status) - 1) . '?)' . "
                ORDER BY a.AdID DESC";

                $param = "%$key%";
                $params = array_merge([$param,$param,$param],$status);
                $stmt = $this->conn->prepare($sql);
                $stmt->bind_param(str_repeat('s', count($status) + 3), ...$params);
                $stmt->execute();
                $result = $stmt->get_result();
                
            }elseif($key!= NULL && $filter != NULL && $stat == NULL ){
                //Request page with search and category, but without status
                $categoryConditions = [];
                foreach ($filter as $category) {
                    $categoryConditions[] = "FIND_IN_SET(?, a.AdCategory) > 0";
                }
                $categoryCondition = implode(' OR ', $categoryConditions);
                $sql = "SELECT COUNT(a.AdID) as total_ads, a.AdName, a.AdDescription, a.Price, a.AdAuthorID, a.AdPicture, a.AdCategory, a.AdPostedDateTime,a.AdPaymentPicture, a.AdStatus, u.UserID, u.UserName
                FROM " . $this->adsTable . " as a, ". $this->userTable . " as u
                WHERE (a.AdName LIKE ? OR a.AdDescription LIKE ? OR u.UserName LIKE ?)
                AND a.AdAuthorID = u.UserID
                AND ($categoryCondition)
                ORDER BY a.AdID DESC";

                $param = "%$key%";
                $params = array_merge([$param,$param,$param],$filter);
                $stmt = $this->conn->prepare($sql);
                $stmt->bind_param(str_repeat('s', count($params)), ...$params);
                $stmt->execute();
                $result = $stmt->get_result();
                
            }elseif($key== NULL && $filter != NULL && $stat == NULL ){
                //Request page with category, but without search and status 
                $categoryConditions = [];
                foreach ($filter as $category) {
                    $categoryConditions[] = "FIND_IN_SET(?, a.AdCategory) > 0";
                }
                $categoryCondition = implode(' OR ', $categoryConditions);
                $sql = "SELECT COUNT(a.AdID) as total_ads, a.AdName, a.AdDescription, a.Price, a.AdAuthorID, a.AdPicture, a.AdCategory, a.AdPostedDateTime,a.AdPaymentPicture, a.AdStatus, u.UserID, u.UserName
                FROM " . $this->adsTable . " as a, ". $this->userTable . " as u
                WHERE a.AdAuthorID = u.UserID
                AND ($categoryCondition)
                ORDER BY a.AdID DESC";

                $stmt = $this->conn->prepare($sql);
                $stmt->bind_param(str_repeat('s', count($filter)), ...$filter);
                $stmt->execute();
                $result = $stmt->get_result();
                
            }elseif($key!= NULL && $filter == NULL && $stat == NULL && $UserID == NULL){
                //Main page with search without category / Request page with search without category and status
                $sql = "SELECT COUNT(a.AdID) as total_ads, a.AdName, a.AdDescription, a.Price, a.AdAuthorID, a.AdPicture, a.AdCategory, a.AdPostedDateTime,a.AdPaymentPicture, a.AdStatus, u.UserID, u.UserName
                FROM " . $this->adsTable . " as a, ". $this->userTable . " as u
                WHERE (a.AdName LIKE ? OR a.AdDescription LIKE ? OR u.UserName LIKE ?)
                AND a.AdAuthorID = u.UserID
                ORDER BY a.AdID DESC";

                $param = "%$key%";
                $stmt = $this->conn->prepare($sql);
                $stmt->bind_param("sss", $param, $param, $param);
                $stmt->execute();
                $result = $stmt->get_result();
                
            }else{
                //Request page with search, category, and status
                $categoryConditions = [];
                foreach ($filter as $category) {
                    $categoryConditions[] = "FIND_IN_SET(?, a.AdCategory) > 0";
                }
            
                $categoryCondition = implode(' OR ', $categoryConditions);
        
                $sql = "SELECT DISTINCT COUNT(a.AdID) as total_ads, a.AdName, a.AdDescription, a.Price, a.AdAuthorID, a.AdPicture, a.AdCategory, a.AdPostedDateTime,a.AdPaymentPicture, a.AdStatus, u.UserID, u.UserName
                        FROM " . $this->adsTable . " as a, " . $this->userTable . " as u
                        WHERE (a.AdName LIKE ? OR a.AdDescription LIKE ? OR u.UserName LIKE ?)
                        AND AdStatus IN (" . str_repeat('?, ', count($status) - 1) . '?)' . "
                        AND a.AdAuthorID = u.UserID
                        AND ($categoryCondition)
                        ORDER BY a.AdID DESC";
                        $param = "%$key%";
                
                $stmt = $this->conn->prepare($sql);
                $stmt->bind_param(str_repeat('s', count($filter) + 3 + count($status)), $param, $param, $param, ...$status, ...$filter);
                $stmt->execute();
                $result = $stmt->get_result();
                if ($result->num_rows > 0) {
                    $row = $result->fetch_assoc();
                    $total = $row['total_ads'];
                    return $total;
                } else {
                    return NULL;
                }
                
            }

            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                $total = $row['total_ads'];
                return $total;
            } else {
                return NULL;
            }
        }

        public function getTotalUsers($timeInterval){
            switch ($timeInterval) {
                case 'day':
                    $sql = "
                        SELECT date_range.date AS Registration_Date, COUNT(users.RegDate) AS Total_Users_Registered
                        FROM (
                            SELECT CURDATE() - INTERVAL (a.a + (10 * b.a) + (100 * c.a)) DAY AS date
                            FROM (
                                SELECT 0 AS a UNION ALL SELECT 1 UNION ALL SELECT 2 UNION ALL SELECT 3 UNION ALL SELECT 4 UNION ALL SELECT 5 UNION ALL SELECT 6 UNION ALL SELECT 7 UNION ALL SELECT 8 UNION ALL SELECT 9
                            ) AS a
                            CROSS JOIN (
                                SELECT 0 AS a UNION ALL SELECT 1 UNION ALL SELECT 2 UNION ALL SELECT 3 UNION ALL SELECT 4 UNION ALL SELECT 5 UNION ALL SELECT 6 UNION ALL SELECT 7 UNION ALL SELECT 8 UNION ALL SELECT 9
                            ) AS b
                            CROSS JOIN (
                                SELECT 0 AS a UNION ALL SELECT 1 UNION ALL SELECT 2 UNION ALL SELECT 3 UNION ALL SELECT 4 UNION ALL SELECT 5 UNION ALL SELECT 6 UNION ALL SELECT 7 UNION ALL SELECT 8 UNION ALL SELECT 9
                            ) AS c
                        ) AS date_range
                        LEFT JOIN users ON DATE(users.RegDate) = date_range.date
                        WHERE date_range.date BETWEEN CURDATE() - INTERVAL 6 DAY AND CURDATE()
                        GROUP BY date_range.date
                        ORDER BY date_range.date;
                    ";
                    break;
                
                case 'week':
                    $sql = "
                    SELECT 
                    week_range.Week_Start_Date,
                    week_range.Week_End_Date,
                    IFNULL(COUNT(users.RegDate), 0) AS Total_Users_Registered
                FROM (
                    SELECT 
                        DATE_SUB(DATE_SUB(CURDATE(), INTERVAL WEEKDAY(CURDATE()) DAY), INTERVAL (7 * (a.a)) DAY) AS Week_Start_Date,
                        DATE_ADD(DATE_SUB(DATE_SUB(CURDATE(), INTERVAL WEEKDAY(CURDATE()) DAY), INTERVAL (7 * (a.a)) DAY), INTERVAL 6 DAY) AS Week_End_Date
                    FROM (
                        SELECT 0 AS a UNION ALL SELECT 1 UNION ALL SELECT 2 UNION ALL SELECT 3
                    ) AS a
                ) AS week_range
                LEFT JOIN users ON users.RegDate BETWEEN week_range.Week_Start_Date AND week_range.Week_End_Date
                GROUP BY week_range.Week_Start_Date
                ORDER BY week_range.Week_Start_Date ASC
                LIMIT 4;
                
                    ";
                    break;
        
                case 'month':
                    $sql = "
                    SELECT 
                    month_range.start_date AS Month_Start_Date,
                    month_range.end_date AS Month_End_Date,
                    IFNULL(COUNT(users.RegDate), 0) AS Total_Users_Registered
                FROM (
                    SELECT 
                        CONCAT(YEAR(CURDATE() - INTERVAL a.a MONTH), '-', LPAD(MONTH(CURDATE() - INTERVAL a.a MONTH), 2, '00'), '-01') AS start_date,
                        LAST_DAY(CURDATE() - INTERVAL a.a MONTH) AS end_date
                    FROM (
                        SELECT 0 AS a UNION ALL SELECT 1 UNION ALL SELECT 2 UNION ALL SELECT 3 UNION ALL SELECT 4 UNION ALL SELECT 5 UNION ALL SELECT 6 UNION ALL SELECT 7 UNION ALL SELECT 8 UNION ALL SELECT 9 UNION ALL SELECT 10 UNION ALL SELECT 11
                    ) AS a
                ) AS month_range
                LEFT JOIN users ON users.RegDate BETWEEN month_range.start_date AND month_range.end_date
                GROUP BY month_range.start_date
                ORDER BY month_range.start_date ASC
                LIMIT 12;                
                    ";
                    break;
                
                default:
                    echo "Invalid time interval provided.";
                    return;
            }

                $stmt = $this->conn->prepare($sql);
                $stmt->execute();
                $result = $stmt->get_result();
                return $result;
        }

        public function getTotalReqAds($timeInterval){
            switch ($timeInterval) {
                case 'day':
                    $sql = "
                    SELECT 
                        date_range.date AS Requested_Date,
                        IFNULL(COUNT(CASE WHEN ads.AdRequestedDate = date_range.date THEN 1 END), 0) AS Total_Ads_Requested,
                        IFNULL(COUNT(CASE WHEN ads.AdApprovedDate = date_range.date THEN 1 END), 0) AS Total_Ads_Approved,
                        IFNULL(COUNT(CASE WHEN ads.AdRejectedDate = date_range.date THEN 1 END), 0) AS Total_Ads_Rejected
                    FROM (
                        SELECT CURDATE() - INTERVAL (a.a + (10 * b.a) + (100 * c.a)) DAY AS date
                        FROM (
                            SELECT 0 AS a UNION ALL SELECT 1 UNION ALL SELECT 2 UNION ALL SELECT 3 UNION ALL SELECT 4 UNION ALL SELECT 5 UNION ALL SELECT 6 UNION ALL SELECT 7 UNION ALL SELECT 8 UNION ALL SELECT 9
                        ) AS a
                        CROSS JOIN (
                            SELECT 0 AS a UNION ALL SELECT 1 UNION ALL SELECT 2 UNION ALL SELECT 3 UNION ALL SELECT 4 UNION ALL SELECT 5 UNION ALL SELECT 6 UNION ALL SELECT 7 UNION ALL SELECT 8 UNION ALL SELECT 9
                        ) AS b
                        CROSS JOIN (
                            SELECT 0 AS a UNION ALL SELECT 1 UNION ALL SELECT 2 UNION ALL SELECT 3 UNION ALL SELECT 4 UNION ALL SELECT 5 UNION ALL SELECT 6 UNION ALL SELECT 7 UNION ALL SELECT 8 UNION ALL SELECT 9
                        ) AS c
                    ) AS date_range
                    LEFT JOIN ads ON DATE(ads.AdRequestedDate) = date_range.date OR DATE(ads.AdApprovedDate) = date_range.date OR DATE(ads.AdRejectedDate) = date_range.date
                    WHERE date_range.date BETWEEN CURDATE() - INTERVAL 6 DAY AND CURDATE()
                    GROUP BY date_range.date
                    ORDER BY date_range.date;
                
                    ";
                    break;
                
                case 'week':
                    $sql = "
                    SELECT 
                        week_range.Week_Start_Date,
                        week_range.Week_End_Date,
                        IFNULL(COUNT(CASE WHEN ads.AdRequestedDate BETWEEN week_range.Week_Start_Date AND week_range.Week_End_Date THEN 1 END), 0) AS Total_Ads_Requested,
                        IFNULL(COUNT(CASE WHEN ads.AdApprovedDate BETWEEN week_range.Week_Start_Date AND week_range.Week_End_Date THEN 1 END), 0) AS Total_Ads_Approved,
                        IFNULL(COUNT(CASE WHEN ads.AdRejectedDate BETWEEN week_range.Week_Start_Date AND week_range.Week_End_Date THEN 1 END), 0) AS Total_Ads_Rejected
                    FROM (
                        SELECT 
                            DATE_SUB(DATE_SUB(CURDATE(), INTERVAL WEEKDAY(CURDATE()) DAY), INTERVAL (7 * (a.a)) DAY) AS Week_Start_Date,
                            DATE_ADD(DATE_SUB(DATE_SUB(CURDATE(), INTERVAL WEEKDAY(CURDATE()) DAY), INTERVAL (7 * (a.a)) DAY), INTERVAL 6 DAY) AS Week_End_Date
                        FROM (
                            SELECT 0 AS a UNION ALL SELECT 1 UNION ALL SELECT 2 UNION ALL SELECT 3
                        ) AS a
                    ) AS week_range
                    LEFT JOIN ads ON 
                        (ads.AdRequestedDate BETWEEN week_range.Week_Start_Date AND week_range.Week_End_Date)
                        OR (ads.AdApprovedDate BETWEEN week_range.Week_Start_Date AND week_range.Week_End_Date)
                        OR (ads.AdRejectedDate BETWEEN week_range.Week_Start_Date AND week_range.Week_End_Date)
                    GROUP BY week_range.Week_Start_Date
                    ORDER BY week_range.Week_Start_Date ASC
                    LIMIT 4;

                    ";
                    break;
        
                case 'month':
                    $sql = "
                    SELECT 
                        month_range.start_date AS Month_Start_Date,
                        month_range.end_date AS Month_End_Date,
                        IFNULL(COUNT(CASE WHEN ads.AdRequestedDate BETWEEN month_range.start_date AND month_range.end_date THEN 1 END), 0) AS Total_Ads_Requested,
                        IFNULL(COUNT(CASE WHEN ads.AdApprovedDate BETWEEN month_range.start_date AND month_range.end_date THEN 1 END), 0) AS Total_Ads_Approved,
                        IFNULL(COUNT(CASE WHEN ads.AdRejectedDate BETWEEN month_range.start_date AND month_range.end_date THEN 1 END), 0) AS Total_Ads_Rejected
                    FROM (
                        SELECT 
                            CONCAT(YEAR(CURDATE() - INTERVAL a.a MONTH), '-', LPAD(MONTH(CURDATE() - INTERVAL a.a MONTH), 2, '00'), '-01') AS start_date,
                            LAST_DAY(CURDATE() - INTERVAL a.a MONTH) AS end_date
                        FROM (
                            SELECT 0 AS a UNION ALL SELECT 1 UNION ALL SELECT 2 UNION ALL SELECT 3 UNION ALL SELECT 4 UNION ALL SELECT 5 UNION ALL SELECT 6 UNION ALL SELECT 7 UNION ALL SELECT 8 UNION ALL SELECT 9 UNION ALL SELECT 10 UNION ALL SELECT 11
                        ) AS a
                    ) AS month_range
                    LEFT JOIN ads ON 
                        (ads.AdRequestedDate BETWEEN month_range.start_date AND month_range.end_date)
                        OR (ads.AdApprovedDate BETWEEN month_range.start_date AND month_range.end_date)
                        OR (ads.AdRejectedDate BETWEEN month_range.start_date AND month_range.end_date)
                    GROUP BY month_range.start_date
                    ORDER BY month_range.start_date ASC
                    LIMIT 12;
           
                    ";
                    break;
                
                default:
                    echo "Invalid time interval provided.";
                    return;
            }

                $stmt = $this->conn->prepare($sql);
                $stmt->execute();
                $result = $stmt->get_result();
                return $result;
        }
    }

    ?>