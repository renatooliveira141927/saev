

import java.io.File;
import java.io.FileInputStream;
import java.io.FileNotFoundException;
import java.io.IOException;
import java.text.DateFormat;
import java.text.ParseException;
import java.text.SimpleDateFormat;
import java.util.Iterator;

import javax.swing.JFileChooser;
import javax.swing.JOptionPane;
import javax.swing.filechooser.FileNameExtensionFilter;

import org.apache.poi.ss.usermodel.Cell;
import org.apache.poi.ss.usermodel.Row;

import importa.dao.ConexaoPostgres;
import importa.model.Aluno;
import importa.model.Escola;
import importa.model.Etapa;
import importa.model.Turma;
import importa.model.Usuario;

import org.apache.poi.hssf.usermodel.HSSFWorkbook;
import org.apache.poi.hssf.usermodel.HSSFSheet;

public class EscolheArquivo {
	
	 public void buscar(Usuario user){
         // Implementa os tipos de arquivos que apareceram para escolha
         FileNameExtensionFilter fileNameExtensionFilter = new FileNameExtensionFilter(
         //descricao , extens�es permitidas
         "Planhilhas", "ods", "xls", "xlsx");
         //Inst�nciando o selecionador de arquivos
         JFileChooser fc = new JFileChooser();
         //Adicionando os arquivos que poderam ser selecionados
         fc.setFileFilter(fileNameExtensionFilter);
         //Nome da tela localizadora de arquvios
        fc.setDialogTitle("Escolhendo arquivo");
        
       //Recebe uma resposta da janela quaso algum evento do localizador de arquivo seja acessado
       int resposta = fc.showOpenDialog(null);
       
       //Verifica se resposta recebida � igual a ok
       if (resposta == JFileChooser.APPROVE_OPTION) {
    	   //JOptionPane.showMessageDialog(null, "Importa��o em progresso! Clique no Bot�o Ok e Aguarde a Mensagem de conclus�o da Importa��o!");
 //Carregando();    	   	   
              //Se sim abre um buffer do arquivo e joga na tela
              File file = new File(fc.getSelectedFile().getAbsolutePath());
              FileInputStream fis;
              try {
                    fis = new FileInputStream(file);                    
                    HSSFWorkbook workbook = new HSSFWorkbook(fis);
                    HSSFSheet planilha = workbook.getSheetAt(0);
                    
                    Iterator<Row> rowIterator = planilha.iterator();         			
         			Integer ano=2018;
         			String estado="";
                                String cidade="";
         			Escola escola = new Escola();
         				   escola.setFl_ativo(true);         	
         			Aluno aluno = null;
         			Turma turma = null;
         			Etapa etapa = null;
         			String celulaAnterior="";	   
         				   
         			//varre todas as linhas da planilha
         			while(rowIterator.hasNext()) {				
         				Row row = rowIterator.next();
         				Iterator<Cell> cellIterator = row.iterator();
         				while(cellIterator.hasNext()) {
         					Cell celula = cellIterator.next();
         					switch (celula.getCellType()) {
         					case STRING: 
         						
         						if(celula.getStringCellValue().toString().equals(new String("Informações da Turma"))) {
		         					celulaAnterior="Informações da Turma";
		         				}
         						if(celula.getStringCellValue().toString().equals(new String("Total de alunos da escola:"))) {
		         					celulaAnterior="Informações da Turma";
		         				}
         						
	         					if(celula.getStringCellValue().toString().equals(new String("Código da escola")) ){
	         						celula = cellIterator.next();
	         						escola.setNr_inep(celula.getStringCellValue());	
	         					}	         					
		         				if(celula.getStringCellValue().toString().equals(new String("Nome da escola:")) ){
		         						celula = cellIterator.next();
		         						celula = cellIterator.next();
		         						escola.setNm_escola(celula.getStringCellValue());
		         				}
		         				if(celula.getStringCellValue().toString().equals(new String("UF:"))) {
		         					celula = cellIterator.next();
	         						celula = cellIterator.next();
		         					estado =celula.getStringCellValue();
		         				}	
		         				
		         				if(celula.getStringCellValue().toString().equals(new String("Município:"))) {
		         						celula = cellIterator.next();
		         						celula = cellIterator.next();
		         						//insere escola		         						
		         						cidade =celula.getStringCellValue();
		         						ConexaoPostgres conectaBanco = new ConexaoPostgres();
		         										conectaBanco.adicionaEscola(escola,estado, cidade,user);
		         										conectaBanco=null;
		         						
		         				}
		         				
		         				if(celula.getStringCellValue().toString().equals(new String("Etapa:"))) {
		         					celula = cellIterator.next();		         					
	         						celula = cellIterator.next();		         						
	         						  if(celula.getStringCellValue()!="") {
	         							etapa = new Etapa();
	         							etapa.setNm_etapa(celula.getStringCellValue());
	         							ConexaoPostgres conectaBanco = new ConexaoPostgres();
 										conectaBanco.adicionaEtapa(etapa,user);
 										conectaBanco.adicionaTurma(turma,etapa,escola,user,ano); 									
 										conectaBanco=null;
	         						  }	
		         				}
		         				
		         				if(celula.getStringCellValue().toString().equals(new String("Nome da turma:"))) {
		         					celula = cellIterator.next();
	         						celula = cellIterator.next();
	         						turma = new Turma();
	         							turma.setNm_turma(celula.getStringCellValue());	         							
		         					
		         				}
                                                        
                                                        if(celulaAnterior.equals("Forma de ingresso do aluno")) {
		         					aluno = new Aluno();
		         					aluno.setNr_inep(celula.getStringCellValue());
		         					celula = cellIterator.next();
		         					aluno.setNm_aluno(celula.getStringCellValue());
		         					celula = cellIterator.next();
		         					String dataString = celula.getStringCellValue();
		         					DateFormat fmt = new SimpleDateFormat("dd/MM/yyyy");
		         					java.sql.Date data = null;
									try {
										data = new java.sql.Date(fmt.parse(dataString).getTime());
									} catch (ParseException e) {
										// TODO Auto-generated catch block
										e.printStackTrace();
									}
		         					
		         					aluno.setDt_nascimento(data);
		         					celula = cellIterator.next();
		         					celula = cellIterator.next();
		         					celula = cellIterator.next();
		         					celula = cellIterator.next();
		         					celula = cellIterator.next();
		         					celula = cellIterator.next();
		         					ConexaoPostgres conectaBancoAluno = new ConexaoPostgres();
		         						conectaBancoAluno.adicionaAluno(aluno,escola,estado,cidade,user);
			         					conectaBancoAluno.adicionaEnturmacao(escola,turma, aluno,user,ano);
			         					conectaBancoAluno=null;		         							         					
		         				}
         						
         						if(celula.getStringCellValue().toString().equals(new String("Modalidade: "))) {
		         					celula = cellIterator.next();
	         						celula = cellIterator.next();
	         						if(celula.getStringCellValue().equals(new String("Ensino Regular"))) {
	         							turma.setTp_turma("R");
	         							turma.setNr_ano_letivo(2018);
	         						}
		         				}
		         				
		         				
		         				if(celula.getStringCellValue().toString().equals(new String("Forma de ingresso do aluno"))) {
		         					celulaAnterior="Forma de ingresso do aluno";
		         				}
		         				
		         				if(celula.getStringCellValue().toString().equals(new String("Informações da Turma"))) {
		         					celulaAnterior="Informações da Turma";
		         				}
		         				
         					break;
         					case BLANK:
         						celulaAnterior="Informações da Turma";         						
         					default:
         						break;
         					}        					
         				}
         			}         			
         			JOptionPane.showMessageDialog(null, "Importação Concluída!");         			
             } catch (FileNotFoundException e) {
            	  JOptionPane.showMessageDialog(null,e.getMessage());
             } catch (IOException e) {
            	 JOptionPane.showMessageDialog(null,e.getMessage());
             } catch (InterruptedException e) {
            	 	JOptionPane.showMessageDialog(null,e.getMessage());
			}
       	  }
	 }
	/* private void Carregando() {
		 Carregando tela = new Carregando();
		 	tela.setTitle("Carregando");
			tela.setDefaultCloseOperation(JFrame.EXIT_ON_CLOSE);
			tela.pack();
			tela.setSize(540, 340);
			tela.setVisible(true);
	 }*/
}
