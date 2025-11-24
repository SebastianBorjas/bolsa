<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SubareaSeeder extends Seeder
{
    public function run(): void
    {
        $subareas = [
            ['id_subarea' => 1, 'id_area' => 1, 'nombre_subarea' => 'Auxiliar administrativo', 'descripcion' => 'Soporte en tareas administrativas y de oficina.'],
            ['id_subarea' => 2, 'id_area' => 1, 'nombre_subarea' => 'Recepcionista', 'descripcion' => 'Atiende y gestiona la recepción de clientes y llamadas.'],
            ['id_subarea' => 3, 'id_area' => 1, 'nombre_subarea' => 'Contador', 'descripcion' => 'Registra y analiza la información financiera.'],
            ['id_subarea' => 4, 'id_area' => 1, 'nombre_subarea' => 'Asistente de recursos humanos', 'descripcion' => 'Apoya la gestión y administración del personal.'],
            ['id_subarea' => 5, 'id_area' => 1, 'nombre_subarea' => 'Archivista', 'descripcion' => 'Organiza y mantiene archivos y documentación.'],
            ['id_subarea' => 6, 'id_area' => 1, 'nombre_subarea' => 'Analista de nómina', 'descripcion' => 'Gestiona el procesamiento de pagos de personal.'],
            ['id_subarea' => 7, 'id_area' => 1, 'nombre_subarea' => 'Secretario ejecutivo', 'descripcion' => 'Coordina agendas y comunicación ejecutiva.'],
            ['id_subarea' => 8, 'id_area' => 2, 'nombre_subarea' => 'Albañil', 'descripcion' => 'Realiza trabajos de construcción y reparaciones en obra.'],
            ['id_subarea' => 9, 'id_area' => 2, 'nombre_subarea' => 'Electricista', 'descripcion' => 'Instala y mantiene sistemas eléctricos.'],
            ['id_subarea' => 10, 'id_area' => 2, 'nombre_subarea' => 'Plomero', 'descripcion' => 'Gestiona instalaciones y reparaciones de sistemas de plomería.'],
            ['id_subarea' => 11, 'id_area' => 2, 'nombre_subarea' => 'Carpintero', 'descripcion' => 'Trabaja la madera en estructuras y mobiliario.'],
            ['id_subarea' => 12, 'id_area' => 2, 'nombre_subarea' => 'Pintor de obra', 'descripcion' => 'Aplica pintura y acabados en edificaciones.'],
            ['id_subarea' => 13, 'id_area' => 2, 'nombre_subarea' => 'Técnico en aire acondicionado', 'descripcion' => 'Instala y repara sistemas de climatización.'],
            ['id_subarea' => 14, 'id_area' => 2, 'nombre_subarea' => 'Instalador de paneles solares', 'descripcion' => 'Implementa sistemas de energía solar en edificaciones.'],
            ['id_subarea' => 15, 'id_area' => 3, 'nombre_subarea' => 'Técnico en soporte de computadoras', 'descripcion' => 'Brinda soporte técnico y soluciona problemas de hardware.'],
            ['id_subarea' => 16, 'id_area' => 3, 'nombre_subarea' => 'Desarrollador web', 'descripcion' => 'Crea y mantiene sitios y aplicaciones web.'],
            ['id_subarea' => 17, 'id_area' => 3, 'nombre_subarea' => 'Programador', 'descripcion' => 'Desarrolla software y aplicaciones de diversa índole.'],
            ['id_subarea' => 18, 'id_area' => 3, 'nombre_subarea' => 'Especialista en redes', 'descripcion' => 'Administra y optimiza redes de comunicación.'],
            ['id_subarea' => 19, 'id_area' => 3, 'nombre_subarea' => 'Administrador de base de datos', 'descripcion' => 'Gestiona sistemas de bases de datos y su rendimiento.'],
            ['id_subarea' => 20, 'id_area' => 3, 'nombre_subarea' => 'Técnico en ciberseguridad', 'descripcion' => 'Implementa medidas para proteger sistemas informáticos.'],
            ['id_subarea' => 21, 'id_area' => 3, 'nombre_subarea' => 'Tester de software', 'descripcion' => 'Realiza pruebas y verifica la calidad de aplicaciones.'],
            ['id_subarea' => 22, 'id_area' => 4, 'nombre_subarea' => 'Enfermero(a)', 'descripcion' => 'Proporciona cuidados y atención médica.'],
            ['id_subarea' => 23, 'id_area' => 4, 'nombre_subarea' => 'Paramédico', 'descripcion' => 'Asiste en emergencias y traslados médicos.'],
            ['id_subarea' => 24, 'id_area' => 4, 'nombre_subarea' => 'Psicólogo clínico', 'descripcion' => 'Ofrece atención y terapias psicológicas.'],
            ['id_subarea' => 25, 'id_area' => 4, 'nombre_subarea' => 'Fisioterapeuta', 'descripcion' => 'Realiza terapias para recuperación del movimiento.'],
            ['id_subarea' => 26, 'id_area' => 4, 'nombre_subarea' => 'Auxiliar de laboratorio clínico', 'descripcion' => 'Apoya en pruebas y análisis médicos.'],
            ['id_subarea' => 27, 'id_area' => 4, 'nombre_subarea' => 'Nutriólogo', 'descripcion' => 'Asesora sobre alimentación y hábitos saludables.'],
            ['id_subarea' => 29, 'id_area' => 5, 'nombre_subarea' => 'Maestro de primaria', 'descripcion' => 'Enseña en niveles básicos de educación.'],
            ['id_subarea' => 30, 'id_area' => 5, 'nombre_subarea' => 'Profesor de secundaria o preparatoria', 'descripcion' => 'Imparte clases en niveles intermedios y altos.'],
            ['id_subarea' => 31, 'id_area' => 5, 'nombre_subarea' => 'Instructor técnico', 'descripcion' => 'Capacita en oficios y habilidades técnicas.'],
            ['id_subarea' => 32, 'id_area' => 5, 'nombre_subarea' => 'Pedagogo', 'descripcion' => 'Desarrolla y evalúa metodologías educativas.'],
            ['id_subarea' => 33, 'id_area' => 5, 'nombre_subarea' => 'Tutor particular', 'descripcion' => 'Ofrece apoyo educativo personalizado.'],
            ['id_subarea' => 34, 'id_area' => 5, 'nombre_subarea' => 'Coordinador académico', 'descripcion' => 'Gestiona programas y actividades escolares.'],
            ['id_subarea' => 35, 'id_area' => 5, 'nombre_subarea' => 'Orientador vocacional', 'descripcion' => 'Asesora en la elección de carrera y desarrollo profesional.'],
            ['id_subarea' => 36, 'id_area' => 6, 'nombre_subarea' => 'Personal de limpieza', 'descripcion' => 'Realiza labores de aseo y mantenimiento de espacios.'],
            ['id_subarea' => 38, 'id_area' => 6, 'nombre_subarea' => 'Vigilante o guardia de seguridad', 'descripcion' => 'Monitorea y protege áreas e instalaciones.'],
            ['id_subarea' => 39, 'id_area' => 6, 'nombre_subarea' => 'Jardinero', 'descripcion' => 'Se ocupa del cuidado y diseño de áreas verdes.'],
            ['id_subarea' => 40, 'id_area' => 6, 'nombre_subarea' => 'Mensajero', 'descripcion' => 'Realiza entregas internas y externas.'],
            ['id_subarea' => 41, 'id_area' => 6, 'nombre_subarea' => 'Lavandero', 'descripcion' => 'Gestiona el lavado y cuidado de textiles.'],
            ['id_subarea' => 42, 'id_area' => 6, 'nombre_subarea' => 'Auxiliar de mantenimiento', 'descripcion' => 'Apoya en tareas generales de reparación y cuidado.'],
            ['id_subarea' => 43, 'id_area' => 7, 'nombre_subarea' => 'Operador de máquina industrial', 'descripcion' => 'Maneja equipos y maquinaria en procesos productivos.'],
            ['id_subarea' => 44, 'id_area' => 7, 'nombre_subarea' => 'Ensamblador', 'descripcion' => 'Realiza el montaje de componentes en productos.'],
            ['id_subarea' => 45, 'id_area' => 7, 'nombre_subarea' => 'Inspector de calidad', 'descripcion' => 'Verifica el cumplimiento de estándares de producción.'],
            ['id_subarea' => 46, 'id_area' => 7, 'nombre_subarea' => 'Técnico en mantenimiento industrial', 'descripcion' => 'Realiza revisiones y ajustes en maquinaria.'],
            ['id_subarea' => 47, 'id_area' => 7, 'nombre_subarea' => 'Soldador', 'descripcion' => 'Une piezas mediante procesos de soldadura.'],
            ['id_subarea' => 48, 'id_area' => 7, 'nombre_subarea' => 'Empacador', 'descripcion' => 'Prepara y embala productos para distribución.'],
            ['id_subarea' => 49, 'id_area' => 7, 'nombre_subarea' => 'Supervisor de línea de producción', 'descripcion' => 'Supervisa el flujo y calidad en la manufactura.'],
            ['id_subarea' => 51, 'id_area' => 8, 'nombre_subarea' => 'Cajero', 'descripcion' => 'Gestiona cobros y manejo de caja en puntos de venta.'],
            ['id_subarea' => 52, 'id_area' => 8, 'nombre_subarea' => 'Ejecutivo de ventas', 'descripcion' => 'Coordina y cierra ventas con clientes.'],
            ['id_subarea' => 53, 'id_area' => 8, 'nombre_subarea' => 'Representante comercial', 'descripcion' => 'Realiza visitas y presenta productos a clientes.'],
            ['id_subarea' => 55, 'id_area' => 8, 'nombre_subarea' => 'Marketing', 'descripcion' => 'Realiza ventas y seguimiento vía telefónica.'],
            ['id_subarea' => 56, 'id_area' => 8, 'nombre_subarea' => 'Encargado de tienda', 'descripcion' => 'Administra operaciones y el equipo de tienda.'],
            ['id_subarea' => 57, 'id_area' => 9, 'nombre_subarea' => 'Diseñador gráfico', 'descripcion' => 'Crea diseños visuales para medios digitales y tradicionales.'],
            ['id_subarea' => 58, 'id_area' => 9, 'nombre_subarea' => 'Fotógrafo', 'descripcion' => 'Realiza capturas artísticas y profesionales de imágenes.'],
            ['id_subarea' => 59, 'id_area' => 9, 'nombre_subarea' => 'Ilustrador', 'descripcion' => 'Produce dibujos e ilustraciones creativas.'],
            ['id_subarea' => 60, 'id_area' => 9, 'nombre_subarea' => 'Escenógrafo', 'descripcion' => 'Diseña escenarios para producciones artísticas o teatrales.'],
            ['id_subarea' => 61, 'id_area' => 9, 'nombre_subarea' => 'Decorador de interiores', 'descripcion' => 'Planifica y organiza la estética de espacios interiores.'],
            ['id_subarea' => 62, 'id_area' => 9, 'nombre_subarea' => 'Editor de video', 'descripcion' => 'Monta y edita contenidos audiovisuales.'],
            ['id_subarea' => 63, 'id_area' => 9, 'nombre_subarea' => 'Artista visual', 'descripcion' => 'Crea obras con diversos medios artísticos.'],
            ['id_subarea' => 64, 'id_area' => 7, 'nombre_subarea' => 'Ingeniero de procesos', 'descripcion' => 'Optimiza y mejora procesos en una empresa para que sean más eficientes y efectivos.'],
            ['id_subarea' => 65, 'id_area' => 7, 'nombre_subarea' => 'Logística y distribución', 'descripcion' => 'Gestiona el flujo de productos desde el origen hasta el cliente final de forma eficiente.'],
            ['id_subarea' => 66, 'id_area' => 9, 'nombre_subarea' => 'Animador 3D', 'descripcion' => 'El animador 3D crea movimientos y expresiones para personajes, objetos o entornos digitales en tres dimensiones, usados en cine, videojuegos o publicidad.'],
            ['id_subarea' => 67, 'id_area' => 8, 'nombre_subarea' => 'Comercio electrónico', 'descripcion' => 'El profesional de comercio electrónico gestiona la venta de productos o servicios a través de plataformas digitales, incluyendo tiendas en línea, logística y marketing digital.'],
            ['id_subarea' => 68, 'id_area' => 7, 'nombre_subarea' => 'Metalúrgico', 'descripcion' => 'Especialista en procesos de fundición y tratamiento de metales, clave en la siderurgia.'],
            ['id_subarea' => 69, 'id_area' => 6, 'nombre_subarea' => 'Chofer', 'descripcion' => 'El chofer conduce vehículos para transportar personas o mercancías, siguiendo rutas y normas de tránsito establecidas.'],
            ['id_subarea' => 70, 'id_area' => 5, 'nombre_subarea' => 'Maestro de inglés', 'descripcion' => 'El maestro de inglés enseña el idioma inglés, incluyendo gramática, vocabulario, pronunciación y comprensión.'],
            ['id_subarea' => 71, 'id_area' => 2, 'nombre_subarea' => 'Topógrafo', 'descripcion' => 'Realiza mediciones y estudios de terrenos para proyectos de construcción.'],
            ['id_subarea' => 72, 'id_area' => 2, 'nombre_subarea' => 'Operador de maquinaria pesada', 'descripcion' => 'Maneja excavadoras, retroexcavadoras o grúas en obras de construcción.'],
            ['id_subarea' => 73, 'id_area' => 2, 'nombre_subarea' => 'Arquitecto', 'descripcion' => 'Diseña, planifica y supervisa proyectos arquitectónicos, considerando aspectos estéticos, funcionales y estructurales.'],
            ['id_subarea' => 74, 'id_area' => 4, 'nombre_subarea' => 'Medico general', 'descripcion' => 'Brinda atención médica básica y diagnósticos generales.'],
            ['id_subarea' => 76, 'id_area' => 6, 'nombre_subarea' => 'Cocinero', 'descripcion' => 'Persona que prepara y elabora alimentos.'],
        ];

        DB::table('subareas')->insert($subareas);
    }
}
