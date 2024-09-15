<?php
// Kết nối đến cơ sở dữ liệu
$servername = "localhost";
$username = "saoke";
$password = "";
$dbname = "saoke";

$conn = new mysqli($servername, $username, $password, $dbname);

// Kiểm tra kết nối
if ($conn->connect_error) {
  die("Kết nối thất bại: " . $conn->connect_error);
}

// Xử lý tìm kiếm khi form được submit
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $searchTerm = $_POST["searchTerm"];

  // Kiểm tra dữ liệu nhập vào
  if (empty($searchTerm) || trim($searchTerm) === "") {
    echo "Vui lòng nhập ít nhất 1 ký tự vào!";
  } else {
    // Chuyển đổi chữ có dấu thành không dấu, viết hoa thành viết thường
    $searchTerm = mb_strtolower(removeDiacritics($searchTerm)); 

    // Truy vấn dữ liệu từ cơ sở dữ liệu
    $sql = "SELECT * FROM saoke WHERE DATE LIKE '%$searchTerm%' OR NOIDUNG LIKE '%$searchTerm%' OR SOTIEN LIKE '%$searchTerm%' OR NAME LIKE '%$searchTerm%'";
    $result = $conn->query($sql);

    // Hiển thị kết quả tìm kiếm
    if ($result->num_rows > 0) {
      echo "<h2>Kết quả tìm kiếm:</h2>";
      while($row = $result->fetch_assoc()) {
        echo "<div class='result'>";
        echo "<span>NGÀY : " . $row["DATE"] . "</span>";
        echo "<span>NỘI DUNG: " . $row["NOIDUNG"] . "</span>";
        echo "<span style='color:green;'>SỐ TIỀN:<b> " . $row["SOTIEN"] . "</b></span>"; // Thay đổi màu chữ
        echo "<span>TÊN: " . $row["NAME"] . "</span>";
        echo "</div>";
      }
    } else {
      echo "Không tìm thấy kết quả nào phù hợp!";
    }
  }
}

// Hàm chuyển đổi chữ có dấu thành không dấu
function removeDiacritics($string) {
  $string = str_replace(
    array('à', 'á', 'ạ', 'ả', 'ã', 'â', 'ầ', 'ấ', 'ậ', 'ẩ', 'ẫ', 'ă', 'ằ', 'ắ', 'ặ', 'ẳ', 'ẵ',
          'è', 'é', 'ẹ', 'ẻ', 'ẽ', 'ê', 'ề', 'ế', 'ệ', 'ể', 'ễ',
          'ì', 'í', 'ị', 'ỉ', 'ĩ',
          'ò', 'ó', 'ọ', 'ỏ', 'õ', 'ô', 'ồ', 'ố', 'ộ', 'ổ', 'ỗ', 'ơ', 'ờ', 'ớ', 'ợ', 'ở', 'ỡ',
          'ù', 'ú', 'ụ', 'ủ', 'ũ', 'ư', 'ừ', 'ứ', 'ự', 'ử', 'ữ',
          'ỳ', 'ý', 'ỵ', 'ỷ', 'ỹ',
          'đ', 'À', 'Á', 'Ạ', 'Ả', 'Ã', 'Â', 'Ầ', 'Ấ', 'Ậ', 'Ẩ', 'Ẫ', 'Ă', 'Ằ', 'Ắ', 'Ặ', 'Ẳ', 'Ẵ',
          'È', 'É', 'Ẹ', 'Ẻ', 'Ẽ', 'Ê', 'Ề', 'Ế', 'Ệ', 'Ể', 'Ễ',
          'Ì', 'Í', 'Ị', 'Ỉ', 'Ĩ',
          'Ò', 'Ó', 'Ọ', 'Ỏ', 'Õ', 'Ô', 'Ồ', 'Ố', 'Ộ', 'Ổ', 'Ỗ', 'Ơ', 'Ờ', 'Ớ', 'Ợ', 'Ở', 'Ỡ',
          'Ù', 'Ú', 'Ụ', 'Ủ', 'Ũ', 'Ư', 'Ừ', 'Ứ', 'Ự', 'Ử', 'Ữ',
          'Ỳ', 'Ý', 'Ỵ', 'Ỷ', 'Ỹ',
          'Đ'),
    array('a', 'a', 'a', 'a', 'a', 'a', 'a', 'a', 'a', 'a', 'a', 'a', 'a', 'a', 'a', 'a', 'a',
          'e', 'e', 'e', 'e', 'e', 'e', 'e', 'e', 'e', 'e', 'e',
          'i', 'i', 'i', 'i', 'i',
          'o', 'o', 'o', 'o', 'o', 'o', 'o', 'o', 'o', 'o', 'o', 'o', 'o', 'o', 'o', 'o', 'o',
          'u', 'u', 'u', 'u', 'u', 'u', 'u', 'u', 'u', 'u', 'u',
          'y', 'y', 'y', 'y', 'y',
          'd', 'A', 'A', 'A', 'A', 'A', 'A', 'A', 'A', 'A', 'A', 'A', 'A', 'A', 'A', 'A', 'A',
          'E', 'E', 'E', 'E', 'E', 'E', 'E', 'E', 'E', 'E', 'E',
          'I', 'I', 'I', 'I', 'I',
          'O', 'O', 'O', 'O', 'O', 'O', 'O', 'O', 'O', 'O', 'O', 'O', 'O', 'O', 'O', 'O', 'O',
          'U', 'U', 'U', 'U', 'U', 'U', 'U', 'U', 'U', 'U', 'U',
          'Y', 'Y', 'Y', 'Y', 'Y',
          'D'),
    $string);
  return $string;
}

// Form tìm kiếm
?>

<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
  <label for="searchTerm">Nội dung cần tìm:</label>
  <input type="text" id="searchTerm" name="searchTerm">
  <input type="submit" value="Tìm">
</form>

<?php
$conn->close();
?>

<style>
/* Form tìm kiếm */
form {
  display: flex;
  justify-content: center;
  align-items: center;
  margin-top: 20px;
}

/* Input */
input[type="text"] {
  width: 300px;
  padding: 10px;
  border: 1px solid #ccc;
  border-radius: 5px;
  margin-right: 10px;
  font-size: 16px;
}

/* Nút submit */
input[type="submit"] {
  padding: 10px 20px;
  border: none;
  border-radius: 5px;
  background-color: #007bff; /* Màu xanh dương */
  color: white;
  font-size: 16px;
  cursor: pointer;
}

/* Hover hiệu ứng cho nút submit */
input[type="submit"]:hover {
  background-color: #0056b3; /* Màu xanh dương đậm hơn */
}

/* Tiêu đề kết quả tìm kiếm */
h2 {
  color: #007bff;
  margin-top: 30px;
}

/* Mỗi kết quả tìm kiếm */
.result {
  background-color: #f2f2f2;
  padding: 15px;
  margin-bottom: 10px;
  border-radius: 5px;
}

/* Dữ liệu trong mỗi kết quả */
.result span {
  display: block;
  margin-bottom: 5px;
}

/* Font chữ cho kết quả tìm kiếm */
.result {
  font-family: Arial, sans-serif;
  font-size: 14px;
}
</style>
