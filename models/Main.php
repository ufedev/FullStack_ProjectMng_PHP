<?php

namespace Models;

use PHPMailer\PHPMailer\PHPMailer as Mail;
use PHPMailer\PHPMailer\SMTP;

abstract class Main
{

    public static string $table = "";
    public static string $alertas = "";
    public $id;
    public static $db;
    public $createAt;
    public $updateAt;

    public static function setDB($db): void
    {
        static::$db = $db;
    }

    protected function cleanData(): ?array
    {
        $clean_data = [];

        foreach ($this as $key => $value) {
            if ($key === "id") continue;
            $clean_data[$key] = static::$db->real_escape_string(htmlspecialchars(trim($value ?? '')));
        }

        return $clean_data;
    }
    protected static function query($qry)
    {
        $res = static::$db->query($qry);
        return $res;
    }
    public function sincData()
    {
    }
    protected static function createObj($data): static
    {
        $obj = new static();
        foreach ($data as $key => $value) {
            if (property_exists($obj, $key)) {
                $obj->$key = $value;
            }
        }
        return $obj;
    }
    protected static function walkRes($res): array
    {
        $data = [];
        while ($value = $res->fetch_assoc()) {
            $data[] = static::createObj($value);
        }
        return $data;
    }
    public function prepareToSave(): void
    {
        $this->createAt = date('Y-m-d H:i:s');
        $this->updateAt = date('Y-m-d H:i:s');
    }
    public function save()
    {
        if ($this->id) {
            return $this->update();
        } else {
            return $this->create();
        }
    }
    protected function create(): ?bool
    {
        $data = $this->cleanData();
        $keys = join(",", array_keys($data));
        $values = join("','", array_values($data));


        $qry = "INSERT INTO " . static::$table;
        $qry .= "(" . $keys . ") VALUES";
        $qry .= "('" . $values . "')";

        return static::query($qry);
    }
    protected function update(): ?bool
    {   //cada vez que se llama esta función se actualiza esta fecha.
        $this->updateAt = date("Y-m-d H:i:s");
        $data = [];
        foreach ($this as $key => $value) {
            if ($key === "id") continue;
            $data[] = "$key='$value'";
        }

        $statement = join(",", $data);

        $query = "UPDATE " . static::$table;
        $query .= " SET " . $statement;
        $query .= " WHERE id=" . $this->id;

        $res = static::query($query);
        return $res;
    }
    /**
     * Sincroniza los nuevos datos
     */
    public function sinc($args = []): void
    {
        foreach ($args as $key => $value) {
            if ($key === "id") continue;
            if (property_exists($this, $key)) {
                $this->$key = static::$db->real_escape_string(htmlspecialchars(trim($value ?? "")));
            }
        }
    }
    public function delete(): ?bool
    {
        $qry = "DELETE FROM " . static::$table;
        $qry .= " WHERE id =" . $this->id . " LIMIT 1";

        $result = static::query($qry);
        return $result;
    }

    public static function findAll(): array
    {
        $query = "SELECT * FROM " . static::$table;
        $res = static::query($query);
        $res = static::walkRes($res);

        return $res;
    }
    public static function findOne($id): ?object
    {
        $query = "SELECT * FROM " . static::$table . " WHERE id=" . $id . " LIMIT 1";
        $res = static::query($query);
        if ($res->num_rows === 0) {
            return null;
        } else {
            $shift = static::walkRes($res);
            return array_shift($shift);
        }
    }
    public static function findOneBy($table, $value): ?static
    {
        $query = "SELECT * FROM " . static::$table . " WHERE $table='" . $value . "'";
        $res = static::query($query);
        if ($res->num_rows === 0) {
            return null;
        } else {
            $shift = static::walkRes($res);
            return array_shift($shift);
        }
    }
    public static function findBy($table, $value): ?array
    {
        $query = "SELECT * FROM " . static::$table . " WHERE $table='" . $value . "'";
        $res = static::query($query);
        if ($res->num_rows === 0) {
            return null;
        } else {
            $shift = static::walkRes($res);
            return $shift;
        }
    }


    // Mails



    public function sendMail(?string $from, ?string $to, ?string $toName, ?string $subject, ?string $content): ?bool
    {
        $mail = new Mail();

        try {
            //Server settings
            //$mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
            $mail->isSMTP();                                            //Send using SMTP
            $mail->Host       = MAIL_HOST;                     //Set the SMTP server to send through
            $mail->SMTPAuth   = MAIL_AUTH;                                   //Enable SMTP authentication
            $mail->Username   = MAIL_USER;                     //SMTP username
            $mail->Password   = MAIL_PASS;                               //SMTP password
            //$mail->SMTPSecure = Mail::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
            $mail->Port       = MAIL_PORT;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

            //Recipients
            $mail->setFrom($from);
            $mail->addAddress($to, $toName);     //Add a recipient


            //Content
            $mail->isHTML(true);                                  //Set email format to HTML
            $mail->Subject = $subject;
            $mail->Body    =  $content;


            $mail->send();
            return true;
        } catch (e) {
            return null;
        }
    }
}
