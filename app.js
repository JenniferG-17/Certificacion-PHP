//Aquí estamos importando el paquete express
const express = require('express');

//Inicializamos app con el paquete express
const app = express();

//Rutas a las que accederemos
app.get('/',  (req, res) => {
    res.send('Estamos en el método GET de nuestro AHD');
});

//Importamos paquete mongoose de Conexión a Mongo DB
const mongoose = require('mongoose');

//Importar Body-Parser
const bodyParser = require('body-parser');

app.use(bodyParser.json());

//Importamos Routes
const rutasRoute = require('./routes/rutas');

app.use('/api', rutasRoute);

//Conexión a la Base de datos de Mongo DB
mongoose.connect('mongodb://localhost:27017/Base_de_Datos_NoSQL', () => console.log('Conexión a Mongo DB Exitosa'));


//Escuchando al Servidor
app.listen(3000);