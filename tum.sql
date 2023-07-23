
SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


CREATE TABLE `student` (
  `student_id` int(11) NOT NULL,
  `name` varchar(200) NOT NULL,
  `national_id` varchar(200) NOT NULL,
  `phone` varchar(200) NOT NULL,
  `address` varchar(200) NOT NULL,
  `adm` varchar(200) NOT NULL,
  `password` varchar(200) NOT NULL,
  `profile_pic` varchar(200) NOT NULL,
  `client_number` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


INSERT INTO `student` (`student_id`, `name`, `national_id`, `phone`, `address`, `adm`, `password`, `profile_pic`, `client_number`) VALUES
(1, 'Solomon Wamutu', '36756481', '9897890089', '127007 Localhost', 'bssc/351j/2019', 'a69681bcf334ae130217fea4505fd3c994f5683f', '', 'iBank-CLIENT-8127');

CREATE TABLE `ib_systemsettings` (
  `id` int(20) NOT NULL,
  `sys_name` longtext NOT NULL,
  `sys_tagline` longtext NOT NULL,
  `sys_logo` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `ib_systemsettings` (`id`, `sys_name`, `sys_tagline`, `sys_logo`) VALUES
(1, 'Student login', 'University at sea level.', 'ibankinglg.png');


ALTER TABLE `student`
  ADD PRIMARY KEY (`student_id`);

ALTER TABLE `ib_systemsettings`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `student`
  MODIFY `student_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

ALTER TABLE `ib_systemsettings`
  MODIFY `id` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
