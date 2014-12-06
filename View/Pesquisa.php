
      <br>
    <form method="post" action="ajax/busca_pesquisar.php" name="pesquisar_form" id="pesquisar_form" > 
    <!---------------------- TABELA PRINCIPAL ---------------------->
    <fieldset align="center" >
        <table width='100%' height='100%' align="center" border="0" bordercolor="#000000" style="background-color:#FFFFFF" >
                <tr class="hero-unit">
                    <td NOWRAP='NOWRAP'>
                        <label>Empresa:</label> 
                    </td>
                    <td colspan="2">
                        <select class="span2" id="empresa" name="empresa" onchange="validate()">
                            <option value="1" selected>SMTUC</option>
                            <option value="nada" >N/A</option>
                        </select>
                    </td>
                    <td>
                        <label>Origem:</label> 
                    </td>
                    <td>
                        <input class="span2" type="text" name="origem" id="origem"> 
                    </td>
                    <td>
                        <label>Destino:</label> 
                    </td>
                    <td>
                        <input class="span2" type="text" name="destino" id="destino"> 
                    </td>
                </tr>
                <tr class="hero-unit">
                    <td>
                        <label>Veiculo:</label> 
                    </td>
                    <td colspan="2">
                       <select class="span2" id="veiculo" name="veiculo" onchange="validate()">
                            <option value="1">Carro</option>
                            <option value="2">Autocarro</option>
                            <option value="3">Expresso</option>
                            <option value="4">Comboio</option>
                            <option value="5">Avi&atilde;o</option>
                            <option value="6">A P&eacute;..</option>
                            <option value="nada" selected>N/A</option>
                       </select>
                    </td>
                    <td>
                      <label>Data Inicio:</label> 
                    </td>
                    <td>
                        <input class="span2" type="date" name="data_inicio" id="data_inicio"> 
                    </td>
                     <td>
                      <label>Data Fim:</label> 
                    </td>
                    <td>
                        <input class="span2" type="date" name="data_inicio" id="data_inicio"> 
                    </td>
                 </tr>
                 <tr class="hero-unit">
                   <td NOWRAP='NOWRAP'> 
                        <label> Mais R&aacute;pido
                        <input type="checkbox"  name="check_gas" id="check_gas" value="check" onclick="validate()"></label>
                   </td>
                   <td align="left" >
                        <label>Mais Curto
                        <input type="checkbox"  name="check_electricidade" id="check_electricidade" value="check"  onclick="validate()"></label>
                        
                   </td>
                   <td align="left" WIDTH="200">
                      <label>Menos transbordos
                      <input type="checkbox"  name="check_servicos" id="check_servicos" value="check"  onclick="validate()"></label>
                   </td>
                   <td>
                        <label>Pre&ccedil;o m&aacute;ximo:</label> 
                    </td>
                    <td>
                        <input class="span2" type="text" name="preco" id="preco"> 
                    </td>
                    <td>
                        <label> Ordenar Por: </label>
                    </td>
                    <td>
                         <select class="span2" id="ordenar" name="ordenar">
                            <option value="nada" selected></option>
                        </select>
                    </td>
                 </tr>
                 <tr>
                    <td colspan="7" align="right">
                        <input type='submit' value='Procurar' id="Procurar" name="Procurar" class="btn btn-danger" />
                    </td>
                 </tr> 
                   
    </table>
    </fieldset>
    </form>
    <div id="resposta" align="center">
                                    
    </div>
    <br><br><br><br><br>