<div class="container">
        <div class="container">
            <div class="logmod__wrapper">
                <form id="formT" class="logmod__container_add_day" action="index.php?controller=poll&amp;action=add" method="POST">
                    <ul class="logmod__tabs">
                        <div class="sminputs">
                            <div class="input full">
                                <label class="string optional" for="user-name">Titulo</label>
                                <input class="string optional" required maxlength="255" id="user-email" placeholder="Titulo" name="title" type="text" size="50">
                            </div>
                        </div>
                    </ul>
                    <div  class="schedule-pos table-autoscroll">
                        <div class="schedule-day">
                            <label class="string optional" for="user-name">Dia</label>
                            <div>
                                <input class="input-date" type="date" name="day[0][0]" id="">
                                <button class="btn btn-small-day"><svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24"><path d="M9 19c0 .552-.448 1-1 1s-1-.448-1-1v-10c0-.552.448-1 1-1s1 .448 1 1v10zm4 0c0 .552-.448 1-1 1s-1-.448-1-1v-10c0-.552.448-1 1-1s1 .448 1 1v10zm4 0c0 .552-.448 1-1 1s-1-.448-1-1v-10c0-.552.448-1 1-1s1 .448 1 1v10zm5-17v2h-20v-2h5.711c.9 0 1.631-1.099 1.631-2h5.315c0 .901.73 2 1.631 2h5.712zm-3 4v16h-14v-16h-2v18h18v-18h-2z"/></svg></button>
                            </div>
                            
                            <div class="schedule-date" id="dia0">
                                <div class="schedule-date-pos">
                                    <input type="time" name="day[0][1][hourInit]" class="timeIn" id="">
                                    <input type="time" name="day[0][1][hourEnd]" class="timeIn" id="">
                                </div>
                                <button class="btn btn-small"><svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24"><path d="M9 19c0 .552-.448 1-1 1s-1-.448-1-1v-10c0-.552.448-1 1-1s1 .448 1 1v10zm4 0c0 .552-.448 1-1 1s-1-.448-1-1v-10c0-.552.448-1 1-1s1 .448 1 1v10zm4 0c0 .552-.448 1-1 1s-1-.448-1-1v-10c0-.552.448-1 1-1s1 .448 1 1v10zm5-17v2h-20v-2h5.711c.9 0 1.631-1.099 1.631-2h5.315c0 .901.73 2 1.631 2h5.712zm-3 4v16h-14v-16h-2v18h18v-18h-2z"/></svg></button>
                            </div>
                            <input type="button" value="Añadir Hora" class="btn btn-time">
                        </div>
                        
                    </div>
                    <div class="add-day" id="AñadirFecha" >
                        <input type="button" value="" >
                        <svg class="add-day-icon" width="24" height="24" xmlns="http://www.w3.org/2000/svg" fill-rule="evenodd" clip-rule="evenodd"><path d="M20 15h4.071v2h-4.071v4.071h-2v-4.071h-4.071v-2h4.071v-4.071h2v4.071zm-8 6h-12v-2h12v2zm0-4.024h-12v-2h12v2zm0-3.976h-12v-2h12v2zm12-4h-24v-2h24v2zm0-4h-24v-2h24v2z"/></svg>
                    </div>
                </form>
            </div>
        </div>
        <div class="accept-poll-banner">
            <div class="accept-poll-banner-pos">
                <button id="enviarform" class="btn btn-primary">Enviar</button>
            </div>

        </div>
    </div>
    