<?php

namespace App\DesignPatterns\Singleton;

use Illuminate\Support\Facades\DB;
use PDO;
use PDOException;

/**
 * Class DatabaseConnection
 * Lớp Singleton quản lý kết nối cơ sở dữ liệu
 * Đảm bảo chỉ có một kết nối duy nhất đến cơ sở dữ liệu trong toàn bộ ứng dụng
 */
class DatabaseConnection
{
    private static ?DatabaseConnection $instance = null;
    private ?PDO $connection = null;
    private bool $inTransaction = false;

    /**
     * Constructor private để ngăn việc tạo instance trực tiếp
     * Khởi tạo kết nối đến cơ sở dữ liệu
     */
    private function __construct()
    {
        $this->connect();
    }

    /**
     * Phương thức clone private để ngăn việc sao chép instance
     */
    private function __clone() {}

    /**
     * Lấy instance duy nhất của DatabaseConnection
     *
     * @return DatabaseConnection Instance duy nhất của DatabaseConnection
     */
    public static function getInstance(): DatabaseConnection
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    /**
     * Thiết lập kết nối đến cơ sở dữ liệu
     * Sử dụng PDO để tạo kết nối an toàn
     *
     * @throws PDOException Nếu không thể kết nối đến cơ sở dữ liệu
     */
    private function connect(): void
    {
        try {
            $this->connection = DB::connection()->getPdo();
        } catch (PDOException $e) {
            throw new PDOException("Kết nối thất bại: " . $e->getMessage());
        }
    }

    /**
     * Lấy đối tượng kết nối PDO
     *
     * @return PDO Đối tượng kết nối PDO
     */
    public function getConnection(): PDO
    {
        return $this->connection;
    }

    /**
     * Bắt đầu một transaction mới
     *
     * @return bool True nếu bắt đầu transaction thành công, false nếu đã trong transaction
     */
    public function beginTransaction(): bool
    {
        if (!$this->inTransaction) {
            $this->inTransaction = $this->connection->beginTransaction();
        }
        return $this->inTransaction;
    }

    /**
     * Lưu các thay đổi của transaction hiện tại
     *
     * @return bool True nếu commit thành công, false nếu không có transaction nào đang chạy
     */
    public function commit(): bool
    {
        if ($this->inTransaction) {
            $result = $this->connection->commit();
            $this->inTransaction = false;
            return $result;
        }
        return false;
    }

    /**
     * Hủy bỏ các thay đổi của transaction hiện tại
     *
     * @return bool True nếu rollback thành công, false nếu không có transaction nào đang chạy
     */
    public function rollback(): bool
    {
        if ($this->inTransaction) {
            $result = $this->connection->rollBack();
            $this->inTransaction = false;
            return $result;
        }
        return false;
    }

    /**
     * Kiểm tra xem có đang trong transaction hay không
     *
     * @return bool True nếu đang trong transaction, false nếu không
     */
    public function isInTransaction(): bool
    {
        return $this->inTransaction;
    }

    /**
     * Thực thi câu truy vấn trả về dữ liệu
     *
     * @param string $query Câu truy vấn SQL
     * @param array $params Các tham số cho câu truy vấn
     * @return array Kết quả truy vấn dưới dạng mảng kết hợp
     * @throws PDOException Nếu thực thi truy vấn thất bại
     */
    public function executeQuery(string $query, array $params = []): array
    {
        try {
            $stmt = $this->connection->prepare($query);
            $stmt->execute($params);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            throw new PDOException("Thực thi truy vấn thất bại: " . $e->getMessage());
        }
    }

    /**
     * Thực thi câu truy vấn không trả về dữ liệu (INSERT, UPDATE, DELETE)
     *
     * @param string $query Câu truy vấn SQL
     * @param array $params Các tham số cho câu truy vấn
     * @return int Số dòng bị ảnh hưởng bởi câu truy vấn
     * @throws PDOException Nếu thực thi truy vấn thất bại
     */
    public function executeNonQuery(string $query, array $params = []): int
    {
        try {
            $stmt = $this->connection->prepare($query);
            $stmt->execute($params);
            return $stmt->rowCount();
        } catch (PDOException $e) {
            throw new PDOException("Thực thi truy vấn thất bại: " . $e->getMessage());
        }
    }
}
