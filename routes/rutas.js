//Aquí estamos importando el Paquete express
const express = require('express');

//Inicializamos variable router con el paquete express.Router()
const router = express.Router();

//Creamos la ruta para acceder desde el navegador
router.get('/', (req, res) => {
    res.send('Estamos en el Home del API');
});

//Importar Models
const { Cursos } = require('../models/modelos');
const { Alumnos } = require('../models/modelos');
const { Instructores } = require('../models/modelos');

router.post('/cursos', async (req, res) => {
    //esta variable post es la que asigna a cada campo el json que recibe en la url
    const saveCursos = new Cursos({
        nombre: req.body.nombre,
        duracion: req.body.duracion,
        fecha_inicio: req.body.fecha_inicio,
        fecha_fin: req.body.fecha_fin
    });
    try {
        const savePost = await saveCursos.save();//con esta instruccion guardamos en la DB
        res.json(savePost);//Devolvemos respuesta de lo guardado
    } catch (err) {
        res.json({ message: err });
    }
});

//Obtener Registros Cursos
router.get('/cursos', async (req, res) => {
    try {
        const getCursos = await Cursos.find();
        res.json(getCursos);
    } catch (err) {
        res.json({ message: err });
    }
});

//Obtener Registro Curso Específico
router.get('/cursos/:cursoId', async (req, res) => {
    try {
        const getCursoById = await Cursos.findById(req.params.cursoId);
        res.json(getCursoById);
    } catch (err) {
        res.json({ message: err });
    }
});

//Eliminar un Curso Especifico
router.delete('/cursos/:cursoId', async (req, res) => {
    try {
        const removeCursoById = await Cursos.remove({ _id: req.params.cursoId });
        res.json(removeCursoById);
    } catch (err) {
        res.json({ message: err });
    }
});

//Modificando un registro Especifico
router.patch('/cursos/:cursoId', async (req, res) => {
    try {
        const updateCursoById = await Cursos.updateOne({ _id: req.params.cursoId }, {
            $set: {
                nombre: req.body.nombre,
                duracion: req.body.duracion
            }
        });

        res.json(updateCursoById);

    } catch (err) {

        res.json({ message: err });

    }
});

//Obtener Registros Alumnos
router.get('/alumnos', async (req, res) => {
    try {
        const getAlumnos = await Alumnos.find();
        //Aquí obtenemos todos los documentos de la colección Alumnos
        res.json(getAlumnos);
    } catch (err) {
        res.json({ message: err });
    }
});

//Obtener Registro Alunmos Específico 
router.get('/alumnos/:alumnoId', async (req, res) => {
    try {
        const getAlumnoById = await Alumnos.findById(req.params.alumnoId);
        res.json(getAlumnoById);
    } catch (err) {
        res.json({ message: err });
    }
});
// Eliminar un Alumno Específico 
router.delete('/alumnos/:alumnoId', async (req, res) => {
    try {
        const removealumnoById = await Alumnos.remove({ _id: req.params.alumnoId });
        res.json(removeAlumnoById);
    } catch (err) {
        res.json({ message: err });
    }
});

//Modificar un Alumno Específico 
router.patch('/alumnos/:alumnoId', async (req, res) => {
    try {
        const updateAlumnoById = await Alumnos.updateOne({ _id: req.params.alumnoId }, {
            $set: {
                nombre: req.body.nombre,
                apellido: req.body.apellido,
                fecha_nacimiento: req.body.fecha_nacimiento,
                telefono: req.body.telefono,
                direccion: req.body.direccion,
                email: req.body.email

            }
        });
        res.json(updateAlumnoById);
    } catch (err) {
        res.json({ message: err });
    }
});

//Agregamos registro Alumno
router.post('/alumnos', async (req, res) => {
    // esta variable post es la que asigna a cada campo el json que recibe en la url    
    const saveAlumnos = new Alumnos({
        nombre: req.body.nombre,
        apellido: req.body.apellido,
        fecha_nacimiento: req.body.fecha_nacimiento,
        telefono: req.body.telefono,
        direccion: req.body.direccion,
        email: req.body.email
    });
    try {
        const savedPost = await saveAlumnos.save();
        // con esta instrucción guardamos en la DB         
        res.json(savedPost);
        // Devolvemos respuesta de lo guardado    
    } catch (err) {
        res.json({ message: err });
    }
});

//Obtener Registros Instructores
router.get('/instructores', async (req, res) => {
    try {
        const getInstructores = await Instructores.find();
        //Aquí obtenemos todos los documentos de la colección Instructores
        res.json(getInstructores);
    } catch (err) {
        res.json({ message: err });
    }
});

//Obtener Registro Instructores Específico 
router.get('/instructores/:instructorId', async (req, res) => {
    try {
        const getInstructorById = await Instructores.findById(req.params.instructorId);
        res.json(getInstructorById);
    } catch (err) {
        res.json({ message: err });
    }
});
// Eliminar un Instructor Específico 
router.delete('/instructores/:instructorId', async (req, res) => {
    try {
        const removeinstructorById = await Instructores.remove({ _id: req.params.instructorId });
        res.json(removeInstructorById);
    } catch (err) {
        res.json({ message: err });
    }
});

//Modificar un instructores Específico 
router.patch('/instructores/:instructorId', async (req, res) => {
    try {
        const updateInstructorById = await Instructores.updateOne({ _id: req.params.instructorId }, {
            $set: {
                nombre: req.body.nombre,
                apellido: req.body.apellido,
                fecha_nacimiento: req.body.fecha_nacimiento,
                telefono: req.body.telefono,
                email: req.body.email

            }
        });
        res.json(updateInstructorById);
    } catch (err) {
        res.json({ message: err });
    }
});

//Agregamos registro instructor
router.post('/instructores', async (req, res) => {
    // esta variable post es la que asigna a cada campo el json que recibe en la url    
    const saveInstructores = new Instructores({
        nombre: req.body.nombre,
        apellido: req.body.apellido,
        fecha_nacimiento: req.body.fecha_nacimiento,
        telefono: req.body.telefono,
        email: req.body.email
    });
    try {
        const savedPost = await saveInstructores.save();
        // con esta instrucción guardamos en la DB         
        res.json(savedPost);
        // Devolvemos respuesta de lo guardado    
    } catch (err) {
        res.json({ message: err });
    }
});




//Exportamos el router para poder leerlo en otros archivos
module.exports = router;

