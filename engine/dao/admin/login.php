<?php
/**
 * Created by PhpStorm.
 * User: CrazyBobik
 * Date: 11.10.2015
 * Time: 15:40
 */
class DAO_Admin_Login extends DAO_DB{
	public static function getUser($login, $pass){
		$stmt = self::init()->db->prepare('SELECT `id` FROM `users`
											WHERE `login`=:login AND `pass`=:pass');
		$stmt->bindParam(':login', $login);
		$stmt->bindParam(':pass', $pass);
		$stmt->execute();

		return $stmt->fetch(PDO::FETCH_ASSOC);
	}
}