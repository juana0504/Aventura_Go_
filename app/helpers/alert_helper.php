<?php

/**  * Función para imprimir SweetAlert dinámico con estilo */
function mostrarSweetAlert($tipo, $titulo, $mensaje, $redirect = null)
{
    echo "
    <html>
        <head>
            <meta charset='UTF-8'>
            <style>
                @import url('https://fonts.googleapis.com/css2?family=Raleway:wght@400;600;700;800&family=Lato:wght@300;400;700&display=swap');

                *, *::before, *::after {
                    margin: 0;
                    padding: 0;
                    box-sizing: border-box;
                }

                body {
                    min-height: 100vh;
                    display: flex;
                    align-items: center;
                    justify-content: center;
                    overflow: hidden;
                    background: #1a2a3a;
                    font-family: 'Lato', sans-serif;
                    color: #fff;
                    position: relative;
                }

                body::before {
                    content: '';
                    position: fixed;
                    inset: 0;
                    background:
                        radial-gradient(ellipse at 20% 50%, rgba(45,64,89,0.9) 0%, transparent 60%),
                        radial-gradient(ellipse at 80% 20%, rgba(234,130,23,0.25) 0%, transparent 50%),
                        radial-gradient(ellipse at 60% 80%, rgba(45,64,89,0.7) 0%, transparent 55%),
                        linear-gradient(135deg, #0f1e2d 0%, #1a2e42 50%, #0d1a26 100%);
                    z-index: -1;
                }

                /* ── PARTÍCULAS ── */
                .particles {
                    position: fixed;
                    inset: 0;
                    z-index: 1;
                    pointer-events: none;
                    overflow: visible;
                }

                .particle {
                    position: absolute;
                    border-radius: 50%;
                    animation: floatUp linear infinite;
                    bottom: 0;
                    opacity: 0;
                }

                .particle:nth-child(1)  { width:6px;  height:6px;  left:8%;   background:rgba(234,130,23,0.6);  animation-duration:12s; animation-delay:-4s;   }
                .particle:nth-child(2)  { width:4px;  height:4px;  left:15%;  background:rgba(255,255,255,0.3); animation-duration:15s; animation-delay:-10s;  }
                .particle:nth-child(3)  { width:8px;  height:8px;  left:25%;  background:rgba(234,130,23,0.4);  animation-duration:10s; animation-delay:-6s;   }
                .particle:nth-child(4)  { width:3px;  height:3px;  left:35%;  background:rgba(255,255,255,0.5); animation-duration:18s; animation-delay:-2s;   }
                .particle:nth-child(5)  { width:5px;  height:5px;  left:42%;  background:rgba(234,130,23,0.5);  animation-duration:13s; animation-delay:-8s;   }
                .particle:nth-child(6)  { width:7px;  height:7px;  left:55%;  background:rgba(255,255,255,0.2); animation-duration:16s; animation-delay:-12s;  }
                .particle:nth-child(7)  { width:4px;  height:4px;  left:63%;  background:rgba(234,130,23,0.7);  animation-duration:11s; animation-delay:-5s;   }
                .particle:nth-child(8)  { width:6px;  height:6px;  left:72%;  background:rgba(255,255,255,0.35);animation-duration:14s; animation-delay:-9s;   }
                .particle:nth-child(9)  { width:9px;  height:9px;  left:80%;  background:rgba(234,130,23,0.3);  animation-duration:17s; animation-delay:-1s;   }
                .particle:nth-child(10) { width:3px;  height:3px;  left:90%;  background:rgba(255,255,255,0.4); animation-duration:12s; animation-delay:-7s;   }
                .particle:nth-child(11) { width:5px;  height:5px;  left:5%;   background:rgba(234,130,23,0.5);  animation-duration:20s; animation-delay:-14s;  }
                .particle:nth-child(12) { width:4px;  height:4px;  left:48%;  background:rgba(255,255,255,0.25);animation-duration:9s;  animation-delay:-3s;   }
                .particle:nth-child(13) { width:7px;  height:7px;  left:30%;  background:rgba(234,130,23,0.45); animation-duration:14s; animation-delay:-11s;  }
                .particle:nth-child(14) { width:3px;  height:3px;  left:68%;  background:rgba(255,255,255,0.5); animation-duration:11s; animation-delay:-6s;   }
                .particle:nth-child(15) { width:6px;  height:6px;  left:22%;  background:rgba(234,130,23,0.6);  animation-duration:16s; animation-delay:-13s;  }
                .particle:nth-child(16) { width:4px;  height:4px;  left:85%;  background:rgba(255,255,255,0.3); animation-duration:13s; animation-delay:-4s;   }
                .particle:nth-child(17) { width:8px;  height:8px;  left:58%;  background:rgba(234,130,23,0.35); animation-duration:18s; animation-delay:-8s;   }
                .particle:nth-child(18) { width:5px;  height:5px;  left:40%;  background:rgba(255,255,255,0.4); animation-duration:10s; animation-delay:-2s;   }

                @keyframes floatUp {
                    0%   { transform: translateY(0);      opacity: 0;   }
                    10%  { opacity: 1; }
                    90%  { opacity: 0.8; }
                    100% { transform: translateY(-110vh) translateX(30px); opacity: 0; }
                }

                /* ── LÍNEAS DE LUZ ── */
                .light-lines {
                    position: fixed;
                    inset: 0;
                    z-index: 1;
                    pointer-events: none;
                    overflow: hidden;
                }

                .light-lines::before,
                .light-lines::after {
                    content: '';
                    position: absolute;
                    width: 120%;
                    height: 1px;
                    background: linear-gradient(90deg, transparent, rgba(234,130,23,0.3), transparent);
                    animation: scanLine 8s ease-in-out infinite;
                }

                .light-lines::before { top: 30%; left: -10%; animation-delay: 0s; }
                .light-lines::after  { top: 65%; left: -10%; animation-delay: 4s; }

                @keyframes scanLine {
                    0%   { transform: translateX(-100%) skewX(-15deg); opacity: 0; }
                    30%  { opacity: 1; }
                    70%  { opacity: 1; }
                    100% { transform: translateX(100%) skewX(-15deg);  opacity: 0; }
                }

                /* ── SWEETALERT2 ── */
                .swal2-container {
                    z-index: 100 !important;
                }

                .swal2-backdrop-show {
                    background: rgba(0, 0, 0, 0) !important;
                }

                .swal2-popup {
                    font-family: 'Lato', sans-serif !important;
                    border-radius: 20px !important;
                    overflow: hidden !important;
                    box-shadow: 0 30px 80px rgba(0,0,0,0.45) !important;
                    padding: 0 !important;
                    border: none !important;
                    position: relative;
                    z-index: 10;
                }

                /* Franja superior animada */
                .swal2-popup::before {
                    content: '';
                    display: block;
                    height: 6px;
                    width: 100%;
                    background: linear-gradient(90deg, #2D4059 0%, #EA8217 50%, #2D4059 100%);
                    background-size: 200% auto;
                    animation: gradientShift 3s linear infinite;
                    flex-shrink: 0;
                }

                @keyframes gradientShift {
                    0%   { background-position: 0% center; }
                    100% { background-position: 200% center; }
                }

                .swal2-icon {
                    margin-top: 28px !important;
                }

                .swal2-title {
                    font-family: 'Raleway', sans-serif !important;
                    font-size: 24px !important;
                    font-weight: 800 !important;
                    color: #2D4059 !important;
                    letter-spacing: 0.5px !important;
                }

                .swal2-html-container,
                .swal2-content {
                    font-family: 'Lato', sans-serif !important;
                    font-size: 15px !important;
                    color: #666 !important;
                    line-height: 1.7 !important;
                }

                /* Botón confirmar */
                .swal2-styled.swal2-confirm {
                    font-family: 'Raleway', sans-serif !important;
                    font-size: 14px !important;
                    font-weight: 700 !important;
                    letter-spacing: 1.2px !important;
                    background: linear-gradient(135deg, #2D4059 0%, #3a5070 100%) !important;
                    border: none !important;
                    border-radius: 10px !important;
                    padding: 12px 32px !important;
                    box-shadow: 0 6px 20px rgba(45,64,89,0.4) !important;
                    transition: transform 0.2s ease, box-shadow 0.3s ease !important;
                }

                .swal2-styled.swal2-confirm:hover {
                    background: linear-gradient(135deg, #3a5070 0%, #2D4059 100%) !important;
                    transform: translateY(-2px) !important;
                    box-shadow: 0 10px 28px rgba(45,64,89,0.5) !important;
                }

                /* Botón cancelar */
                .swal2-styled.swal2-cancel {
                    font-family: 'Raleway', sans-serif !important;
                    font-size: 14px !important;
                    font-weight: 700 !important;
                    letter-spacing: 1.2px !important;
                    background: linear-gradient(135deg, #EA8217 0%, #d4710f 100%) !important;
                    border: none !important;
                    border-radius: 10px !important;
                    padding: 12px 32px !important;
                    box-shadow: 0 6px 20px rgba(234,130,23,0.35) !important;
                    transition: transform 0.2s ease, box-shadow 0.3s ease !important;
                }

                .swal2-styled.swal2-cancel:hover {
                    background: linear-gradient(135deg, #d4710f 0%, #EA8217 100%) !important;
                    transform: translateY(-2px) !important;
                    box-shadow: 0 10px 28px rgba(234,130,23,0.45) !important;
                }

                .swal2-actions {
                    gap: 12px !important;
                    margin-bottom: 8px !important;
                }
            </style>

            <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>

        </head>

        <body>

            <!-- Fondo interactivo -->
            <div class='particles'>
                <div class='particle'></div>
                <div class='particle'></div>
                <div class='particle'></div>
                <div class='particle'></div>
                <div class='particle'></div>
                <div class='particle'></div>
                <div class='particle'></div>
                <div class='particle'></div>
                <div class='particle'></div>
                <div class='particle'></div>
                <div class='particle'></div>
                <div class='particle'></div>
                <div class='particle'></div>
                <div class='particle'></div>
                <div class='particle'></div>
                <div class='particle'></div>
                <div class='particle'></div>
                <div class='particle'></div>
            </div>
            <div class='light-lines'></div>

            <script>
                Swal.fire({
                    icon: '$tipo',
                    title: '$titulo',
                    text: '$mensaje',
                    confirmButtonText: 'Aceptar',
                    background: '#fff',
                    color: '#2D4059'
                }).then((result) => {
                    " . ($redirect ? "window.location.href = '$redirect';" : "window.history.back();") . "
                });
            </script>
        </body>
    </html>";
}