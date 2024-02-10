-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th12 28, 2022 lúc 06:04 AM
-- Phiên bản máy phục vụ: 10.4.24-MariaDB
-- Phiên bản PHP: 8.0.19

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `dattiec`
--
CREATE DATABASE qldt;
use qldt;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `dattiec`
--

CREATE TABLE `dattiec` (
  `id_dattiec` int(11) NOT NULL,
  `id_loaitiec` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `id_menu` int(11) NOT NULL,
  `soluongban` int(11) NOT NULL,
  `giodat` time NOT NULL,
  `ngaydat` date NOT NULL,
  `giamenu` int(20) NOT NULL,
  `tongtien` int(20) NOT NULL,
  `diachitiec` varchar(100) NOT NULL,
  `phuong` varchar(50) NOT NULL,
  `quan` varchar(50) NOT NULL,
  `tinh` varchar(50) NOT NULL,
  `hinhanhtiec` varchar(50) NOT NULL,
  `trangthai` char(1) NOT NULL DEFAULT '0',
  `ngaythuchien` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Đang đổ dữ liệu cho bảng `dattiec`
--

INSERT INTO `dattiec` (`id_dattiec`, `id_loaitiec`, `id_user`, `id_menu`, `soluongban`, `giodat`, `ngaydat`, `giamenu`, `tongtien`, `diachitiec`, `phuong`, `quan`, `tinh`, `hinhanhtiec`, `trangthai`, `ngaythuchien`) VALUES
(2, 1, 1, 9, 4, '00:00:00', '2022-12-14', 0, 100, '', '', '', '', '', '0', '2022-12-25 14:36:55'),
(6, 1, 1, 7, 50, '12:00:00', '2022-12-29', 100, 5000, 'Tam binh Vinh Long', '', '', '', '', '0', '2022-12-26 15:02:22'),
(7, 1, 1, 7, 50, '08:43:00', '2022-12-30', 100, 5000, 'ádasdasds', 'Xã Vần Chải', 'Huyện Đồng Văn', 'Tỉnh Hà Giang', '', '0', '2022-12-27 13:45:55');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `loaimon`
--

CREATE TABLE `loaimon` (
  `id_loaimon` int(11) NOT NULL,
  `tenloaimon` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Đang đổ dữ liệu cho bảng `loaimon`
--

INSERT INTO `loaimon` (`id_loaimon`, `tenloaimon`) VALUES
(1, 'Mon chinh');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `loaitiec`
--

CREATE TABLE `loaitiec` (
  `id_loaitiec` int(11) NOT NULL,
  `ten_loai` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Đang đổ dữ liệu cho bảng `loaitiec`
--

INSERT INTO `loaitiec` (`id_loaitiec`, `ten_loai`) VALUES
(1, 'Tiệc Cưới');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `menu`
--

CREATE TABLE `menu` (
  `id_menu` int(11) NOT NULL,
  `tenmenu` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Đang đổ dữ liệu cho bảng `menu`
--

INSERT INTO `menu` (`id_menu`, `tenmenu`) VALUES
(4, 'Menu 3'),
(5, 'menu2 nè nhe'),
(6, 'Menu Hải Sản'),
(7, 'Menu Thượng Hạng'),
(9, 'Menu có người đặt');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `menuchitiet`
--

CREATE TABLE `menuchitiet` (
  `id` int(11) NOT NULL,
  `id_menu` int(11) NOT NULL,
  `id_mon` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Đang đổ dữ liệu cho bảng `menuchitiet`
--

INSERT INTO `menuchitiet` (`id`, `id_menu`, `id_mon`) VALUES
(3, 4, 4),
(6, 6, 7),
(12, 5, 6),
(14, 9, 7),
(18, 7, 2),
(19, 7, 4),
(22, 4, 6),
(23, 5, 7),
(24, 9, 5),
(25, 4, 3),
(26, 7, 7);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `monan`
--

CREATE TABLE `monan` (
  `id_mon` int(11) NOT NULL,
  `tenmon` varchar(50) NOT NULL,
  `id_loaimon` int(11) NOT NULL,
  `gia_mon` int(20) NOT NULL,
  `image` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Đang đổ dữ liệu cho bảng `monan`
--

INSERT INTO `monan` (`id_mon`, `tenmon`, `id_loaimon`, `gia_mon`, `image`) VALUES
(1, 'Ga chien nuoc mam', 1, 150000, ''),
(2, 'a', 1, 190000, 'fuji2.PNG'),
(3, 'av', 1, 9000, 'has1.PNG'),
(4, 'a', 1, 190000, 'fuji2.PNG'),
(5, 'Món mới', 1, 100000, 'canhchuacalinh.jpg'),
(6, 'món 2', 1, 34544443, 'comtam.jpg'),
(7, 'Món 4', 1, 435345345, 'bunca.jpg');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `users`
--

CREATE TABLE `users` (
  `id_user` int(11) NOT NULL,
  `admin` char(1) NOT NULL DEFAULT '0',
  `fullname` varchar(50) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `diachi` varchar(100) NOT NULL,
  `phuong` varchar(50) NOT NULL,
  `quan` varchar(50) NOT NULL,
  `tinh` varchar(50) NOT NULL,
  `sdt` varchar(10) NOT NULL,
  `email` varchar(50) NOT NULL,
  `ngaytao` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Đang đổ dữ liệu cho bảng `users`
--

INSERT INTO `users` (`id_user`, `admin`, `fullname`, `username`, `password`, `diachi`, `phuong`, `quan`, `tinh`, `sdt`, `email`, `ngaytao`) VALUES
(1, '0', '', 'Tin Tin', '123', 'AAAA', '', '', '', '4645654', 'tin@gmail.com', '2022-12-25 14:36:28');

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `dattiec`
--
ALTER TABLE `dattiec`
  ADD PRIMARY KEY (`id_dattiec`),
  ADD KEY `id_loaitiec` (`id_loaitiec`),
  ADD KEY `id_user` (`id_user`),
  ADD KEY `dattiec_ibfk_3` (`id_menu`);

--
-- Chỉ mục cho bảng `loaimon`
--
ALTER TABLE `loaimon`
  ADD PRIMARY KEY (`id_loaimon`);

--
-- Chỉ mục cho bảng `loaitiec`
--
ALTER TABLE `loaitiec`
  ADD PRIMARY KEY (`id_loaitiec`);

--
-- Chỉ mục cho bảng `menu`
--
ALTER TABLE `menu`
  ADD PRIMARY KEY (`id_menu`);

--
-- Chỉ mục cho bảng `menuchitiet`
--
ALTER TABLE `menuchitiet`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_mon` (`id_mon`),
  ADD KEY `menuchitiet_ibfk_1` (`id_menu`);

--
-- Chỉ mục cho bảng `monan`
--
ALTER TABLE `monan`
  ADD PRIMARY KEY (`id_mon`),
  ADD KEY `id_loaimon` (`id_loaimon`);

--
-- Chỉ mục cho bảng `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id_user`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `dattiec`
--
ALTER TABLE `dattiec`
  MODIFY `id_dattiec` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT cho bảng `loaimon`
--
ALTER TABLE `loaimon`
  MODIFY `id_loaimon` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT cho bảng `loaitiec`
--
ALTER TABLE `loaitiec`
  MODIFY `id_loaitiec` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT cho bảng `menu`
--
ALTER TABLE `menu`
  MODIFY `id_menu` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT cho bảng `menuchitiet`
--
ALTER TABLE `menuchitiet`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT cho bảng `monan`
--
ALTER TABLE `monan`
  MODIFY `id_mon` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT cho bảng `users`
--
ALTER TABLE `users`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Các ràng buộc cho các bảng đã đổ
--

--
-- Các ràng buộc cho bảng `dattiec`
--
ALTER TABLE `dattiec`
  ADD CONSTRAINT `dattiec_ibfk_1` FOREIGN KEY (`id_loaitiec`) REFERENCES `loaitiec` (`id_loaitiec`),
  ADD CONSTRAINT `dattiec_ibfk_2` FOREIGN KEY (`id_user`) REFERENCES `users` (`id_user`),
  ADD CONSTRAINT `dattiec_ibfk_3` FOREIGN KEY (`id_menu`) REFERENCES `menu` (`id_menu`);

--
-- Các ràng buộc cho bảng `menuchitiet`
--
ALTER TABLE `menuchitiet`
  ADD CONSTRAINT `menuchitiet_ibfk_1` FOREIGN KEY (`id_menu`) REFERENCES `menu` (`id_menu`) ON DELETE CASCADE,
  ADD CONSTRAINT `menuchitiet_ibfk_2` FOREIGN KEY (`id_mon`) REFERENCES `monan` (`id_mon`);

--
-- Các ràng buộc cho bảng `monan`
--
ALTER TABLE `monan`
  ADD CONSTRAINT `monan_ibfk_1` FOREIGN KEY (`id_loaimon`) REFERENCES `loaimon` (`id_loaimon`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
