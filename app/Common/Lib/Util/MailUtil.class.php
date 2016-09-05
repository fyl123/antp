<?php
namespace Common\Lib\Util;
class MailUtil {
	/**
	 * 系统邮件发送函数
	 * @param string $to			接收邮件者邮箱
	 * @param string $subject 		邮件主题
	 * @param string $body    		邮件内容
	 * @param string $attachment 	附件列表
	 * @return boolean
	 */
	public static function send($to, $subject = '', $body = '', $attachment = null){
		vendor('PHPMailer.class#phpmailer');
		$config = C('THINK_EMAIL');
		$mail = new \PHPMailer(); //PHPMailer对象
		$mail->CharSet = 'UTF-8'; //设定邮件编码，默认ISO-8859-1，如果发中文此项必须设置，否则乱码
		$mail->IsHTML(true);
		$mail->IsSMTP();  // 设定使用SMTP服务
		$mail->SMTPDebug  = false;                     // 关闭SMTP调试功能
		$mail->SMTPAuth   = true;                  // 启用 SMTP 验证功能
		$mail->SMTPSecure = 'ssl';                 // 使用安全协议
		$mail->Host       = $config['SMTP_HOST'];  // SMTP 服务器
		$mail->Port       = $config['SMTP_PORT'];  // SMTP服务器的端口号
		$mail->Username   = $config['SMTP_USER'];  // SMTP服务器用户名
		$mail->Password   = $config['SMTP_PASS'];  // SMTP服务器密码
		$mail->SetFrom($config['FROM_EMAIL']);
		$replyEmail       = $config['REPLY_EMAIL'] ? $config['REPLY_EMAIL'] : $config['FROM_EMAIL'];
		$replyName        = $config['REPLY_NAME'] ?  $config['REPLY_NAME'] : $config['FROM_NAME'];
		$mail->AddReplyTo($replyEmail, $replyName);
		$mail->Subject    = $subject;
		$mail->MsgHTML($body);
		if (is_array($to)) {
			foreach ($to as $toItem) {
				$mail->AddAddress($toItem);
			}
		}else{
			$mail->AddAddress($to);
		}
		if(is_array($attachment)){ // 添加附件
			foreach ($attachment as $file){
				is_file($file) && $mail->AddAttachment($file);
			}
		}
		$response = $mail->Send();
		$result = array('status' => false);
		if ($response) {
			$result['status'] = true;
			$result['info'] = 'OK';
		}else{
			$result['info'] = $mail->ErrorInfo;
		}
		return $result;
	}
}

?>