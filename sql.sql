CREATE TABLE `Usuarios` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `apellido` varchar(255) DEFAULT NULL,
  `correo` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;


CREATE TABLE Tareas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    idUsuario INT,
    tarea TEXT,
    FOREIGN KEY (idUsuario) REFERENCES Usuarios(id)
);
