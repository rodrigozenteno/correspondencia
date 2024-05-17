/*
 Navicat Premium Data Transfer

 Source Server         : localhost
 Source Server Type    : MySQL
 Source Server Version : 100421
 Source Host           : localhost:3306
 Source Schema         : dbdoctra1

 Target Server Type    : MySQL
 Target Server Version : 100421
 File Encoding         : 65001

 Date: 31/01/2022 13:26:21
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for registro
-- ----------------------------
DROP TABLE IF EXISTS `registro`;
CREATE TABLE `registro`  (
  `nroDoc` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `fechaEntregaCmte` date NULL DEFAULT NULL,
  `fechaEntrega` date NOT NULL,
  `procedenciaDoc` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `numeroDoc` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `objetoDoc` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `tipoDoc` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `observacionesDoc` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `archivo` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `estado` varchar(15) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  PRIMARY KEY (`nroDoc`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of registro
-- ----------------------------
INSERT INTO `registro` VALUES ('1', '2022-02-28', '2022-02-10', 'procedencia es texto', '23/3', 'rutadeldoc', 'pdf', 'este es una fila para pruebas ', 'RUTA DEL PROYECTO', 'Desabilitado');
INSERT INTO `registro` VALUES ('6', '2022-02-02', '2022-02-06', 'Bolivia', '12345123', 'no se que poner', 'Radiograma', 'Se esta Insertando', 'Cargando', 'Habilitado');
INSERT INTO `registro` VALUES ('codigo-01', '2022-02-03', '2022-02-06', 'Bolivia', '12345', 'no se', 'Informe', '', 'WHM [phoenix] Crear una nueva cuenta - 100.0.5.pdf', 'Activo');

SET FOREIGN_KEY_CHECKS = 1;
