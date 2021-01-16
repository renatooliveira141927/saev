package importa.dao;

import java.sql.Connection;
import java.sql.DriverManager;
import java.sql.PreparedStatement;
import java.sql.ResultSet;
import java.sql.SQLException;
import java.util.Date;

import javax.swing.JOptionPane;

import importa.model.Aluno;
import importa.model.Enturmacao;
import importa.model.Escola;
import importa.model.Etapa;
import importa.model.MicrodadosLP;
import importa.model.MicrodadosMT;
import importa.model.Turma;
import importa.model.Usuario;

public class ConexaoPostgres {
	
	//localprod
public String user  = "postgres";
public String senha = "tamara19";
public String url   = "jdbc:postgresql://localhost:5432/postgres";	

        //treina
//    public String user   = "saevtreina";
//    public String senha = "Gi080900";
//    public String url      = "jdbc:postgresql://saevtreina.postgresql.dbaas.com.br";                
                
	//prod
//    public String user   = "saevprod";
//    public String senha = "Gi080900";
//    public String url      = "jdbc:postgresql://saevprod.postgresql.dbaas.com.br";

//variaveis
int totalregistros=0;
ResultSet rs=null;
PreparedStatement stmt=null;
Connection con=null;
	
	public Connection getConnection() throws SQLException {
		String driver = "org.postgresql.Driver";
		
	    try
	    {
	        Class.forName(driver);	       
	        con = (Connection) DriverManager.getConnection(url, user, senha);	        
	    }
	    catch (ClassNotFoundException ex)
	    {   
	        JOptionPane.showMessageDialog(null,"Driver não encontrado"+ex.getMessage());
	    } 
	    catch (SQLException e)
	    {
	    	JOptionPane.showMessageDialog(null,"Erro ao realizar sql"+e.getMessage());
	    }
		return con;
	}
	
	public Connection getLocalConnection() throws SQLException {
		String driver = "org.postgresql.Driver";
	    String user   = "postgres";
	    String senha = "tamara19";
	    String url      = "jdbc:postgresql://localhost:5432/postgres";	    
	    try
	    {
	        Class.forName(driver);	       
	        con = (Connection) DriverManager.getConnection(url, user, senha);	        
	    }
	    catch (ClassNotFoundException ex)
	    {   
	        JOptionPane.showMessageDialog(null,"Driver não encontrado"+ex.getMessage());
	    } 
	    catch (SQLException e)
	    {
	    	JOptionPane.showMessageDialog(null,"Erro ao realizar sql"+e.getMessage());
	    }
		return con;
	}   
	
	public void adicionaEscola(Escola escola,String estado,String cidade, Usuario user ) throws InterruptedException {

	     try {	         
	    	 Integer idCidade = this.consultaCidade(estado, cidade);
	    	 Escola escolaGravada = this.consultaEscola(escola.getNr_inep());
                 if (escolaGravada!=null && escolaGravada.getId()!=0 && escolaGravada.getFl_ativo()==false){
                      String sql = "update tb_escola " +
	              "set fl_ativo=true " +
	              "where ci_escola= ?";
                     Connection conexao = getConnection();
                     PreparedStatement stmt = conexao.prepareStatement(sql);
                         stmt.setInt(1,escolaGravada.getId());
                         stmt.executeUpdate();
                         stmt.close();	         		
                         conexao.close();
                 }else if(escolaGravada.getId()==0 && idCidade!=0) {
                      String sql = "insert into tb_escola " +
	              "(nr_inep,nm_escola,cd_cidade,fl_ativo,cd_usuario_cad)" +
	              " values (?,?,?,?,?)";
                      
	    	 	 con = getConnection();
	   	    	 stmt = con.prepareStatement(sql);	
		    	 escola.setCd_cidade(idCidade);							    	 
		         stmt.setString(1,escola.getNr_inep());
		         stmt.setString(2,escola.getNm_escola());
		         stmt.setInt(3,escola.getCd_cidade());
		         stmt.setBoolean(4, true);
		         stmt.setInt(5,user.getCi_usuario());	         
		         stmt.execute();		         
                 }     
	    	 
		 } catch (SQLException e) {	         
                        JOptionPane.showMessageDialog(null,"Erro na consulta de Escola:"+e.getMessage());
	 	} catch(RuntimeException e) {
	 		JOptionPane.showMessageDialog(null,"Não foi possível obter conexão de banco no cadastro de Escola");
	 	}finally {
	 		 try {				
				stmt.close();
				con.close();
			} catch (SQLException e) {
				// TODO Auto-generated catch block
				e.printStackTrace();
			}
		}

	 }
	
	public void adicionaAluno(Aluno aluno,Escola escola,String estado, String cidade,Usuario usuario) throws InterruptedException {

	     try {
             Integer idCidade = this.consultaCidade(estado, cidade);
	    	 Escola escolaConsulta = this.consultaEscola(escola.getNr_inep());
	    	 Aluno alunoConsulta = this.consultaAluno(aluno);
	    	 if(alunoConsulta.getCi_aluno()!=0 && alunoConsulta.getFl_ativo()!=true) {
	    		 String sql = "update tb_aluno " +
	   	              "set fl_ativo=true " +
	   	              "where ci_aluno= ?";
	    		 con = getConnection();
                 stmt = con.prepareStatement(sql);
                     stmt.setInt(1,alunoConsulta.getCi_aluno());
                     stmt.executeUpdate();                     
	    	 }else if(alunoConsulta.getCi_aluno()==0) {
	    		 
	    		 String sql = "insert into tb_aluno " +
	   	              "(cd_escola,nr_inep,nm_aluno,dt_nascimento,cd_usuario_cad,cd_cidade,fl_ativo)" +
	   	              " values (?,?,?,?,?,?,?)";
	    		 con = getConnection();
		    	 stmt = con.prepareStatement(sql);
		    	 stmt.setInt(1,escolaConsulta.getId());
		         stmt.setString(2,aluno.getNr_inep());
		         stmt.setString(3,aluno.getNm_aluno());
		         stmt.setDate(4,aluno.getDt_nascimento());
		         stmt.setInt(5,usuario.getCi_usuario());
                         stmt.setInt(6,idCidade);
		         stmt.setBoolean(7, true);	         	         
		         stmt.execute();		             
	    	 }
	     } catch (SQLException e) {	         
	         JOptionPane.showMessageDialog(null,"Erro no insert do Aluno"+e.getMessage());
	     } catch(RuntimeException e) {
                 JOptionPane.showMessageDialog(null,"Não foi possível obter conexão de banco no cadastro de Aluno");
	     }finally {
	 		 try {
				rs.close();
				stmt.close();
				con.close();
			} catch (SQLException e) {
				// TODO Auto-generated catch block
				e.printStackTrace();
			}
		}

	 }
	
	public void adicionaEtapa(Etapa etapa,Usuario user) {
		
	     try {	         	
	    	 Etapa cadEtapa = consultaEtapa(etapa.getNm_etapa());
	    	 
	    	 if(cadEtapa.getCi_etapa()!=0 && cadEtapa.getFl_ativo()!=true) {
	    		 String sql = "update tb_etapa " +
	   	              "set fl_ativo=true " +
	   	              "where ci_etapa= ? ";
	    		 con = getConnection();
                 stmt = con.prepareStatement(sql);
                     stmt.setInt(1,cadEtapa.getCi_etapa());
                     stmt.executeUpdate();                     
	    	 }else if(cadEtapa.getCi_etapa()==0) {
	    		 String sql = "insert into tb_etapa " +
	   	              "(nm_etapa,fl_ativo,cd_usuario_cad)" +
	   	              " values (?,?,?)";
	    		 Connection conexao = getConnection();
		    	 PreparedStatement stmt = conexao.prepareStatement(sql);
		         stmt.setString(1,etapa.getNm_etapa());
		         stmt.setBoolean(2, true);
		         stmt.setInt(3,user.getCi_usuario());	         	         
		         stmt.execute();
		         stmt.close();	         		
		         conexao.close();    
	    	 }    
	     } catch (SQLException e) {	         
	         JOptionPane.showMessageDialog(null,"Erro ao adicionar Etapa"+e.getMessage());
	 	} catch(RuntimeException e) {
	 		JOptionPane.showMessageDialog(null,"Não foi possível obter conexão de banco no cadastro de Etapa");
	 	}finally {
	 		 try {
				stmt.close();
				con.close();
			} catch (SQLException e) {
				// TODO Auto-generated catch block
				e.printStackTrace();
			}
		}

	}
	
	public void adicionaTurma(Turma turma, Etapa etapa,Escola escola,Usuario user, Integer ano) {
		
	     try {	         	
	    	 Etapa cadEtapa = consultaEtapa(etapa.getNm_etapa());
	    	 Escola idEscola = this.consultaEscola(escola.getNr_inep());
	    	 turma.setCd_escola(idEscola.getId());
	    	 turma.setCd_etapa(cadEtapa.getCi_etapa());
	    	 turma.setNr_ano_letivo(ano);
	    	 Turma turmaConsulta = this.consultaTurma(turma,ano);
	    	 if(turmaConsulta.getCi_turma()!=0 && turmaConsulta.getFl_ativo()!=true) {
	    		 String sql = "update tb_turma " +
	   	              "set fl_ativo=true " +
	   	              "where ci_turma= ?";
	    		 con = getConnection();
                 stmt = con.prepareStatement(sql);
                     stmt.setInt(1,turmaConsulta.getCi_turma());
                     stmt.executeUpdate();                     
	    	 }else if(cadEtapa.getCi_etapa()!=0 && turmaConsulta.getCi_turma()==0) {
	    		 String sql = "insert into tb_turma " +
	   	              "(nm_turma,cd_escola,cd_etapa,cd_turno,fl_ativo,"
	   	              + "cd_usuario_cad,tp_turma,nr_ano_letivo)" +
	   	              " values (?,?,?,?,?,?,?,?)";
	    		 con = getConnection();
		    	 stmt = con.prepareStatement(sql);
		         stmt.setString(1,turma.getNm_turma());
		         stmt.setInt(2,idEscola.getId());
		         stmt.setInt(3,cadEtapa.getCi_etapa());
		         stmt.setInt(4,1);
		         stmt.setBoolean(5, true);	
		         stmt.setInt(6,user.getCi_usuario());
		         stmt.setString(7,turma.getTp_turma());
		         stmt.setInt(8,ano);
		         stmt.execute();		         
	    	 }    
	     } catch (SQLException e) {	         
	         JOptionPane.showMessageDialog(null,"Erro ao gravar Turma"+e.getMessage());
	 	} catch(RuntimeException e) {
	 		JOptionPane.showMessageDialog(null,"Não foi possível obter conexão de banco no cadastro de Turma");
	 	}finally {
	 		 try {
	 			 stmt.close();
				con.close();
			} catch (SQLException e) {
				// TODO Auto-generated catch block
				e.printStackTrace();
			}
		}
		
	}
	
	public void adicionaEnturmacao(Escola escola,Turma turma, Aluno aluno, Usuario user, Integer ano) {
		   try {	        
	    	 Aluno idAluno = this.consultaAluno(aluno);
	    	 Escola escolaConsulta = this.consultaEscola(escola.getNr_inep());
	    	 turma.setCd_escola(escolaConsulta.getId());
	    	 Turma idTurma = this.consultaTurma(turma,ano);
	    	 		 turma.setCi_turma(idTurma.getCi_turma());
	    	 Enturmacao idEnturmacao= this.consultaEnturmacao(turma, idAluno,ano);
	    	 
	    	 if(idEnturmacao.getCi_enturmacao()!=0 && idEnturmacao.getFl_ativo()!=true) {
	    		 String sql = "update tb_enturmacao " +
	   	              "set fl_ativo=true " +
	   	              "where ci_enturmacao= ? ";
	    		 con = getConnection();
                 stmt = con.prepareStatement(sql);
                     stmt.setInt(1,idEnturmacao.getCi_enturmacao());
                     stmt.executeUpdate();                     
	    	 }else if(idEnturmacao.getCi_enturmacao()==0 
	    			 	&& idTurma.getCi_turma()!=0 
	    			 	&& idAluno.getCd_escola().equals(idTurma.getCd_escola()) ){
	    		 String sql = "insert into tb_enturmacao " +
	   	              "(cd_aluno,cd_turma,cd_usuario_cad,fl_ativo)" +
	   	              " values (?,?,?,?)";
	    		 Connection conexao = getConnection();
		    	 PreparedStatement stmt = conexao.prepareStatement(sql);
		         stmt.setInt(1,idAluno.getCi_aluno());
		         stmt.setInt(2,idTurma.getCi_turma());
		         stmt.setInt(3,user.getCi_usuario());
		         stmt.setBoolean(4, true);	
		         stmt.execute();
		         stmt.close();	         		
		         conexao.close();    
		         String sql2 = "insert into tb_ultimaenturmacao " +
		   	              "(cd_aluno,cd_turma,cd_usuario_cad,nr_anoletivo)" +
		   	              " values (?,?,?,?)";
		    		 Connection con = getConnection();
			    	 PreparedStatement stm = con.prepareStatement(sql2);
			         stm.setInt(1,idAluno.getCi_aluno());
			         stm.setInt(2,idTurma.getCi_turma());
			         stm.setInt(3,user.getCi_usuario());
			         stm.setInt(4, turma.getNr_ano_letivo());	
			         stm.execute();
			         stm.close();	         		
			         con.close();
	    	 }else if(idEnturmacao.getCi_enturmacao()!=0 && idTurma.getNr_ano_letivo()!=ano  
	    			 	&& idTurma.getCi_turma()!=0 
	    			 	&& idAluno.getCd_escola()==idTurma.getCd_escola()) {
	    		 String sql = "insert into tb_enturmacao " +
	   	              "(cd_aluno,cd_turma,cd_usuario_cad,fl_ativo)" +
	   	              " values (?,?,?,?)";
	    		 con = getConnection();
		    	 stmt = con.prepareStatement(sql);
		         stmt.setInt(1,idAluno.getCi_aluno());
		         stmt.setInt(2,idTurma.getCi_turma());
		         stmt.setInt(3,user.getCi_usuario());
		         stmt.setBoolean(4, true);	
		         stmt.execute();
		         stmt.close();	         		
		         con.close();
		         String sql2 = "insert into tb_ultimaenturmacao " +
		   	              "(cd_aluno,cd_turma,cd_usuario_cad,nr_anoletivo)" +
		   	              " values (?,?,?,?)";
		    		 Connection conex = getConnection();
			    	 PreparedStatement stm = conex.prepareStatement(sql2);
			         stm.setInt(1,idAluno.getCi_aluno());
			         stm.setInt(2,idTurma.getCi_turma());
			         stm.setInt(3,user.getCi_usuario());
			         stm.setInt(4, turma.getNr_ano_letivo());	
			         stm.execute();
			         stm.close();	         		
			         conex.close();
	    	 }else if(idAluno.getCd_escola()!=idTurma.getCd_escola()) {
	    		 JOptionPane.showMessageDialog(null,"O(A) aluno(a):"+
	    				 	idAluno.getNm_aluno()+
	    				 	" está matrículado(a) na Escola:"+idAluno.getNm_escola()+
	    				 	" solicite a esta escola que realize o processo de transferência!"
	    				 	);
	    	 }else {
	    		 JOptionPane.showMessageDialog(null,"Favor enviar o arquivo que foi selecionado para ser analisado pelos administradores!");
	    	 }    
	     } catch (SQLException e) {	         
	         JOptionPane.showMessageDialog(null,"Erro ao adicionar Enturmacao"+e.getMessage());
	 	} catch(RuntimeException e) {
	 		JOptionPane.showMessageDialog(null,"Não foi possível obter conexão de banco no cadastro de Enturmacao");
	 	}finally {
	 		 try {
				stmt.close();
				con.close();
			} catch (SQLException e) {
				// TODO Auto-generated catch block
				e.printStackTrace();
			}
		}
		
	}
	
	public Integer consultaCidade(String estado,String cidade) {
		String sql ="select * from tb_cidade c "
				+ "	inner join tb_estado e on c.cd_estado=e.ci_estado" + 
				" where upper(nm_uf)=upper(?)" + 
				"  and upper(nm_cidade)=upper(?)";
		Integer idCidade=0;		
		try {
			 con = getConnection();
	    	 stmt = con.prepareStatement(sql);
	    	 stmt.setString(1,estado);
	    	 stmt.setString(2,cidade);
	    	 rs = stmt.executeQuery();
	    	 
	    	 if(rs.isBeforeFirst()) {
		    	 while(rs.next()) {
		    		 idCidade=(rs.getInt("ci_cidade"));
		    	 }
	    	 }	 	    	 
	    	 return idCidade;
	    	 
		} catch (SQLException e) {	         
	         JOptionPane.showMessageDialog(null,"Erro ao consultar Cidade"+e.getMessage());
	 	}finally {
	 		 try {
				rs.close();
				stmt.close();
				con.close();
			} catch (SQLException e) {
				// TODO Auto-generated catch block
				e.printStackTrace();
			}
		}
		return null;		
	}
	
	public Usuario consultaUsuario(String usuario,String senha) {		
		String sql ="select * from tb_usuario usr "+
				" where nm_login ilike (?)"
				+ " and ds_senha=md5(?);";
		Usuario user = new Usuario();		
		try {
			 con = getConnection();
	    	 stmt = con.prepareStatement(sql);
	    	 stmt.setString(1,usuario);
	    	 stmt.setString(2,senha);	    	 
	    	 rs = stmt.executeQuery();	    	 	    	 
	    	 if(rs.isBeforeFirst()) {
		    	 while(rs.next()) {
		    		 user.setCi_usuario(rs.getInt("ci_usuario"));
		    		 user.setNm_login(rs.getString("nm_usuario"));
				 }
	    	 }	 
	    	 
	    	 return user;
	    	 
		} catch (SQLException e) {	         
	         JOptionPane.showMessageDialog(null,"Erro ao consultar Usuário"+e.getMessage());
	 	}finally {
	 		 try {
				rs.close();
				stmt.close();
				con.close();
			} catch (SQLException e) {
				// TODO Auto-generated catch block
				e.printStackTrace();
			}
		}
		return null;		
	}
	
	public Escola consultaEscola(String inep) {
		String sql ="select * from tb_escola esc "+
				" where nr_inep=?";
		Escola escola = new Escola();
			   escola.setId(0);
			   escola.setFl_ativo(false);
		try {
			 con = getConnection();
	    	 stmt = con.prepareStatement(sql);
	    	 stmt.setString(1,inep);
	    	 rs = stmt.executeQuery();
	    	 
	    	 if(rs.isBeforeFirst()) {
		    	 while(rs.next()) {
		    		 escola.setId(rs.getInt("ci_escola"));	    		 
	                         escola.setFl_ativo(rs.getBoolean("fl_ativo"));
				 }
	    	 }	 	    	
	    	 return escola;
	    	 
		} catch (SQLException e) {	         
	         JOptionPane.showMessageDialog(null,"Erro ao consultar Escola"+e.getMessage());
	 	}finally {
	 		 try {
				rs.close();
				stmt.close();
				con.close();
			} catch (SQLException e) {
				// TODO Auto-generated catch block
				e.printStackTrace();
			}
		}
		return null;		
	}
	
	public Etapa consultaEtapa(String nmEtapa) {
		String sql ="select * from tb_etapa et "+
				" where upper(nm_etapa) ilike (?);";
		Etapa etapa = new Etapa();
			  etapa.setCi_etapa(0);	
		try {
			 con = getConnection();
	    	 stmt = con.prepareStatement(sql);
	    	 stmt.setString(1,"%"+nmEtapa+"%");
	    	 rs = stmt.executeQuery();
	    	 
	    	 if(rs.isBeforeFirst()) {
		    	 while(rs.next()) {
		    		 etapa.setCi_etapa(rs.getInt("ci_etapa"));
		    		 etapa.setFl_ativo(rs.getBoolean("fl_ativo"));
				 }
	    	 }	 	    	 
	    	 return etapa;
	    	 
		} catch (SQLException e) {	         
	         JOptionPane.showMessageDialog(null,"Erro ao consultar Etapa"+e.getMessage());
	 	}finally {
	 		 try {
				rs.close();
				stmt.close();
				con.close();
			} catch (SQLException e) {
				// TODO Auto-generated catch block
				e.printStackTrace();
			}
		}
		return null;		
	}
	
	public Aluno consultaAluno(Aluno aluno) {		
		String parametro = aluno.getNr_inep().toString();
		String parametro1 = aluno.getNm_aluno().toString().toUpperCase();			
		String sqlal ="select * from tb_aluno al "
				+ "inner join tb_escola esc on al.cd_escola=esc.ci_escola "				
				+ "where al.nr_inep=? or (UPPER(al.nm_aluno)= upper(?) and dt_nascimento= ? )";
		Aluno idAluno = new Aluno();
			  idAluno.setCi_aluno(0);
		try {
			 con = getConnection();
	    	 stmt = con.prepareStatement(sqlal);
	    	 stmt.setString(1,parametro);
	    	 stmt.setString(2,parametro1);	    	 
	    	 stmt.setDate(3,aluno.getDt_nascimento());
	    	 rs = stmt.executeQuery();
	    	 
	    	 if(rs.isBeforeFirst()) {
		    	 while(rs.next()) {
		    		 idAluno.setCi_aluno(rs.getInt("ci_aluno"));
		    		 idAluno.setNm_aluno(rs.getString("nm_aluno"));
		    		 idAluno.setCd_escola(rs.getInt("cd_escola"));
		    		 idAluno.setNm_escola(rs.getString("nm_escola"));
		    		 idAluno.setFl_ativo(rs.getBoolean("fl_ativo"));
				 }
	    	 } 	    	
	    	 return idAluno;
	    	 
		} catch (SQLException e) {	         
	         JOptionPane.showMessageDialog(null,"Erro ao consultar Aluno"+e.getMessage());
	 	}finally {
	 		 try {
				rs.close();
				stmt.close();
				con.close();
			} catch (SQLException e) {
				// TODO Auto-generated catch block
				e.printStackTrace();
			}
		}
		return null;		
	}
	
	public Turma consultaTurma(Turma turma, Integer ano) {
		String sql ="select * from tb_turma "+
				" where nm_turma=? and cd_escola=? and nr_ano_letivo=?"
				+ "and cd_etapa=? ";
		Turma idTurma = new Turma();
			  idTurma.setCi_turma(0);	
		try {
			 con = getConnection();
	    	 stmt = con.prepareStatement(sql);
	    	 stmt.setString(1,turma.getNm_turma());
	    	 stmt.setInt(2,turma.getCd_escola());
	    	 stmt.setInt(3,ano);
	    	 stmt.setInt(4,turma.getCd_etapa());
	    	 rs = stmt.executeQuery();
	    	 
	    	 if(rs.isBeforeFirst()) {
		    	 while(rs.next()) {
		    		 idTurma.setCi_turma(rs.getInt("ci_turma"));
		    		 idTurma.setFl_ativo(rs.getBoolean("fl_ativo"));
		    		 idTurma.setCd_escola(rs.getInt("cd_escola"));
				 }
	    	 }	 	    	
	    	 return idTurma;
	    	 
		} catch (SQLException e) {	         
	         JOptionPane.showMessageDialog(null,"Erro ao consultar Turma"+e.getMessage());
	 	}finally {
	 		 try {
				rs.close();
				stmt.close();
				con.close();
			} catch (SQLException e) {
				// TODO Auto-generated catch block
				e.printStackTrace();
			}
		}
		return null;		
	}
	
	public Enturmacao consultaEnturmacao(Turma turma,Aluno aluno, Integer ano) {
		String sql ="select * from tb_enturmacao et "+
                                "inner join tb_turma t on et.cd_turma=t.ci_turma "+                                
                                "inner join tb_aluno al on et.cd_aluno=al.ci_aluno "+
                                "inner join tb_escola e on al.cd_escola=e.ci_escola "+
			    " where et.cd_aluno=? " + 
			    "	and (" + 
			    "			(t.nr_ano_letivo= ? and al.cd_escola= ?) or " + 
			    "			(t.nr_ano_letivo=? and al.cd_escola=?) ); ";
		Enturmacao idEnturmacao = new Enturmacao();
				   idEnturmacao.setCi_enturmacao(0);
		try {
			 con = getConnection();
	    	 stmt = con.prepareStatement(sql);
	    	 //Turma turmapesquisa = this.consultaTurma(turma,ano);
                 stmt.setInt(1,aluno.getCi_aluno());                 
                 stmt.setInt(2,ano);
                 stmt.setInt(3,turma.getCd_escola());
                 stmt.setInt(4,ano-1);
                 stmt.setInt(5,aluno.getCd_escola());
                 //stmt.setInt(3,turma.getCi_turma());
	    	 rs = stmt.executeQuery();
	    	 
	    	 if(rs.isBeforeFirst()) {
		    	 while(rs.next()) {
		    		 idEnturmacao.setCi_enturmacao(rs.getInt("ci_enturmacao"));
		    		 idEnturmacao.setFl_ativo(rs.getBoolean("fl_ativo"));
	                         idEnturmacao.setEscolaEnturmacao(rs.getString("nm_escola"));
	                         idEnturmacao.setTurmaEnturmacao(rs.getString("nm_turma"));
	                         idEnturmacao.setAlunoEnturmacao(rs.getString("nm_aluno"));
				 }
	    	 }	 	    	 
	    	 return idEnturmacao;
	    	 
		} catch (SQLException e) {	         
	         JOptionPane.showMessageDialog(null,"Erro ao consultar Enturmacao"+e.getMessage());
	 	}finally {
	 		 try {
				rs.close();
				stmt.close();
				con.close();
			} catch (SQLException e) {
				// TODO Auto-generated catch block
				e.printStackTrace();
			}
		}
		return null;		
	}

	public void adicionaMicrodadosLP(MicrodadosLP microdados, int tamanho) throws SQLException {
			// TODO Auto-generated method stub
		String sql2 = "insert into tb_microdados_portugues ("
				+ "cd_projeto,nu_ano,cd_estado,nm_estado,cd_regional,nm_regional,cd_municipio,nm_municipio,cd_escola,nm_escola,"
				+ "cd_rede,dc_rede,cd_localizacao,dc_localizacao,cd_turma,cd_turma_instituicao,nm_turma,cd_turno,dc_turno,fl_anexo_turma,"
				+ "cd_ensino,dc_ensino,cd_aluno,cd_aluno_institucional,cd_aluno_inep,cd_aluno_publicacao,nm_projeto,fl_multi_turma,"
				
				+ "dt_nascimento, cd_sexo, filiacao, dc_deficiencia, nm_disciplina_caderno, cd_disciplin, nm_disciplina, nm_disciplina_sigla, "
				+ "cd_etapa_aplicacao, dc_etapa_aplicacao, cd_etapa_avaliada, dc_etapa_avaliada, cd_etapa, cd_etapa_publicacao, dc_etapa_publicacao, cd_caderno, "
				+ "dc_caderno, nu_caderno, cd_base_versao, nu_sequencial, fl_filtros, dc_filtros, fl_plan_extra, fl_extra, fl_aln_extra, fl_publicacao, dc_publicacao, "
				+ "fl_excluido_planejada, fl_excluido_sujeito, fl_avaliado, fl_preenchido, vl_proficiencia, vl_proficiencia_erro, nu_pontos, vl_perc_acertos, id_mascara, "
				+ "cd_lote, nu_pacote, dc_imagem_cartao, dc_imagem_lista, dc_imagem_ata, dc_imagem_reserva, nu_imagem, id_instrumento, tp_instrumento, dc_desenho_instrumento, "
				+ "tp_processamento, rp, rp_001, rp_002, rp_003, rp_004, rp_005, rp_006, rp_007, rp_008, rp_009, rp_010, rp_011, rp_012, rp_013, rp_014, rp_015, rp_016, rp_017, "
				+ "rp_018, rp_019, rp_020, rp_021, rp_022, rp_023, rp_024, rp_025, rp_026, rp_027, rp_028, rp_029, rp_030, rp_031, rp_032, rp_033, rp_034, rp_035, rp_036, rp_037, "
				+ "rp_038, rp_039, rp_040, rp_041, rp_042, rp_043, rp_044, rp_045, rp_046, rp_047, rp_048, rp_049, rp_050, rp_051, rp_052, rp_053, rp_054, rp_055, rp_056, rp_057, "
				+ "rp_059, rp_058, rpa_001, rpa_002, rpa_003, rpa_004, rpa_005, rpa_006, rpa_007, rpa_008, rpa_009, rpa_010, rpa_011, rpa_012, rpa_013, rpa_014, rpa_015, rpa_016, "
				+ "rpa_017, rpa_018, rpa_019, rpa_020, rpa_021, rpa_022, rpa_023, rpa_024, rpa_025, rpa_026, rpa_027, rpa_028, rpa_029, rpa_030, rpa_031, rpa_032, rpa_033, rpa_034, "
				+ "rpa_035, rpa_036, rpa_037, rpa_038, rpa_039, rpa_040, rpa_041, rpa_042, rpa_043, rpa_044, rpa_045, rpa_046, rpa_047, rpa_048, rpa_049, rpa_050, rpa_051, rpa_052, "
				+ "rpa_053, rpa_054, rpa_055, rpa_056, rpa_057, rpa_058, rpa_059, rpa_060, rpa_061, rpa_062, rpa_063, rpa_064, rpa_065, rpa_066, rpa_067, rpa_068, rpa_069, rpa_070, "
				+ "rpa_071, rpa_072, rpa_073, rpa_074, rpa_075, rpa_076, rpa_077, rpa_078, rpa_079, rpa_080, rpa_081, rpa_082, rpa_083, rpa_084, rpa_085, rpa_086, rpa_087, rpa_088, "
				+ "rpa_089, rpa_090, rpa_091, nu_posicao_lista, rp_lista, dc_turno_escola, tipo, fl_esc_tecnica, fl_seama, fl_saepe, d001_acerto, d001_total, d002_acerto, d002_total, "
				+ "d003_acerto, d003_total, d004_acerto, d004_total, d005_acerto, d005_total, d007_acerto, d007_total, d008_acerto, d008_total, d009_acerto, d009_total, d010_acerto, "
				+ "d010_total, d011_acerto, d011_total, d012_acerto, d012_total, d013_acerto, d013_total, d014_acerto, d014_total, d015_acerto, d015_total, d016_acerto, d016_total, "
				+ "d017_acerto, d017_total, d018_acerto, d018_total, d019_acerto, d019_total, d020_acerto, d020_total, d021_acerto, d021_total, d022_acerto, d022_total, d023_acerto, "
				+ "d023_total, d024_acerto, d024_total, d025_acerto, d025_total, d026_acerto, d026_total,nm_aluno )" +
 	              " values (?,?,?,?,?,?,?,?,?,?,"
 	              + "		?,?,?,?,?,?,?,?,?,?,"
 	              + "		?,?,?,?,?,?,?,?,?,?, "
 	              + "		?,?,?,?,?,?,?,?,?,?,"
 	              + "       ?,?,?,?,?,?,?,?,?,?,"
 	              + "       ?,?,?,?,?,?,?,?,?,?,"
 	              + "		?,?,?,?,?,?,?,?,?,?, "
 	              + "		?,?,?,?,?,?,?,?,?,?, "
 	              + "		?,?,?,?,?,?,?,?,?,?, "
 	              + "		?,?,?,?,?,?,?,?,?,?, " //100
 	              
 	              + "?,?,?,?,?,?,?,?,?,?, "
 	              + "?,?,?,?,?,?,?,?,?,?, "
 	              + "?,?,?,?,?,?,?,?,?,?, "
 	              + "?,?,?,?,?,?,?,?,?,?, "
 	              + "?,?,?,?,?,?,?,?,?,?, "
 	              + "?,?,?,?,?,?,?,?,?,?, "
 	              + "?,?,?,?,?,?,?,?,?,?, "
 	              + "?,?,?,?,?,?,?,?,?,?, "
 	              + "?,?,?,?,?,?,?,?,?,?, "
 	              + "?,?,?,?,?,?,?,?,?,?, " //100
 	              
 	              + "?,?,?,?,?,?,?,?,?,?, "
 	              + "?,?,?,?,?,?,?,?,?,?, "
 	              + "?,?,?,?,?,?,?,?,?,?, "
 	              + "?,?,?,?,?,?,?,?,?,?, "
 	              + "?,?,?,?,?,?,?,?,?,?, "
 	              + "?,?,?,?,?,?,?,?,?,?, "
 	             + "?,?,?,?,?,?,?,?,?,?, "
 	            + "?,?,?,?,?,?,?,?,?,?, "
 	              + "?,?,?,?)"; //84
  		 Connection conex = getConnection();
	    	 PreparedStatement stm = conex.prepareStatement(sql2);
	         	stm.setDouble(1,microdados.getCD_PROJETO());
	         	stm.setDouble(2,microdados.getNU_ANO());
	         	stm.setDouble(3,microdados.getCD_ESTADO());
	         	stm.setString(4,microdados.getNM_ESTADO());
	         	stm.setString(5,microdados.getCD_REGIONAL());
	         	stm.setString(6,microdados.getNM_REGIONAL());
	         	stm.setDouble(7,microdados.getCD_MUNICIPIO());
	         	stm.setString(8,microdados.getNM_MUNICIPIO());
	         	stm.setDouble(9,microdados.getCD_ESCOLA());
	         	stm.setString(10,microdados.getNM_ESCOLA());
	         	stm.setDouble(11,microdados.getCD_REDE());
	         	stm.setString(12,microdados.getDC_REDE());
	         	stm.setDouble(13,microdados.getCD_LOCALIZACAO());
	         	stm.setString(14,microdados.getDC_LOCALIZACAO());
	         	stm.setDouble(15,microdados.getCD_TURMA());
	         	stm.setDouble(16,microdados.getCD_TURMA_INSTITUICAO());
	         	stm.setString(17,microdados.getNM_TURMA());
	         	stm.setDouble(18,microdados.getCD_TURNO());
	         	stm.setString(19,microdados.getDC_TURNO());
	         	stm.setDouble(20,microdados.getFL_ANEXO_TURMA());
	         	stm.setDouble(21,microdados.getCD_ENSINO());
	         	stm.setString(22,microdados.getDC_ENSINO());
	         	stm.setDouble(23,microdados.getCD_ALUNO());
	         	stm.setDouble(24,microdados.getCD_ALUNO_INSTITUCIONAL());
	         	stm.setDouble(25,microdados.getCD_ALUNO_INEP());
	         	stm.setDouble(26,microdados.getCD_ALUNO_PUBLICACAO());	         	
	         	stm.setString(27,microdados.getNM_PROJETO());
	         	stm.setDouble(28,microdados.getNU_ANO());
	         		         	
	         	stm.setString(29,microdados.getDT_NASCIMENTO());
	         	stm.setString(30,microdados.getCD_SEXO());
	         	stm.setString(31,microdados.getFILIACAO());
            	stm.setString(32,microdados.getDC_DEFICIENCIA());
            	stm.setString(33,microdados.getNM_DISCIPLINA_CADERNO());
            	stm.setDouble(34,microdados.getCD_DISCIPLIN());
            	stm.setString(35,microdados.getNM_DISCIPLINA());
            	stm.setString(36,microdados.getNM_DISCIPLINA_SIGLA());
            	stm.setDouble(37,microdados.getCD_ETAPA_APLICACAO());
            	stm.setString(38,microdados.getDC_ETAPA_APLICACAO());
            	stm.setDouble(39,microdados.getCD_ETAPA_AVALIADA());
            	stm.setString(40,microdados.getDC_ETAPA_AVALIADA());
            	stm.setDouble(41,microdados.getCD_ETAPA());
            	stm.setDouble(42,microdados.getCD_ETAPA_PUBLICACAO());
            	stm.setString(43,microdados.getDC_ETAPA_PUBLICACAO());
            	stm.setDouble(44,microdados.getCD_CADERNO());
            	stm.setString(45,microdados.getDC_CADERNO());
            	stm.setDouble(46,microdados.getNU_CADERNO());
            	stm.setDouble(47,microdados.getCD_BASE_VERSAO());
            	stm.setDouble(48,microdados.getNU_SEQUENCIAL());
            	stm.setDouble(49,microdados.getFL_FILTROS());
            	stm.setString(50,microdados.getDC_FILTROS());
            	stm.setDouble(51,microdados.getFL_PLAN_EXTRA());
            	stm.setDouble(52,microdados.getFL_EXTRA());
            	stm.setDouble(53,microdados.getFL_ALN_EXTRA());
            	stm.setDouble(54,microdados.getFL_PUBLICACAO());
            	stm.setString(55,microdados.getDC_PUBLICACAO());
            	stm.setString(56,microdados.getFL_EXCLUIDO_PLANEJADA());
            	stm.setString(57,microdados.getFL_EXCLUIDO_SUJEITO());
            	stm.setDouble(58,microdados.getFL_AVALIADO());
            	stm.setDouble(59,microdados.getFL_PREENCHIDO());
            	stm.setString(60,microdados.getVL_PROFICIENCIA());
            	stm.setDouble(61,microdados.getVL_PROFICIENCIA_ERRO());
            	stm.setDouble(62,microdados.getNU_PONTOS());
            	stm.setDouble(63,microdados.getVL_PERC_ACERTOS());
            	stm.setDouble(64,microdados.getID_MASCARA());
            	stm.setDouble(65,microdados.getCD_LOTE());
            	stm.setDouble(66,microdados.getNU_PACOTE());
            	stm.setString(67,microdados.getDC_IMAGEM_CARTAO());
            	stm.setString(68,microdados.getDC_IMAGEM_LISTA());
            	stm.setString(69,microdados.getDC_IMAGEM_ATA());
            	stm.setString(70,microdados.getDC_IMAGEM_RESERVA());
            	stm.setString(71,microdados.getNU_IMAGEM());
            	stm.setString(72,microdados.getID_INSTRUMENTO());
            	stm.setString(73,microdados.getTP_INSTRUMENTO());
            	stm.setString(74,microdados.getDC_DESENHO_INSTRUMENTO());
            	stm.setString(75,microdados.getTP_PROCESSAMENTO());
            	stm.setString(76,microdados.getRP());
            	stm.setString(77,microdados.getRP_001());
            	stm.setString(78,microdados.getRP_002());
            	stm.setString(79,microdados.getRP_003());
            	stm.setString(80,microdados.getRP_004());
            	stm.setString(81,microdados.getRP_005());
            	stm.setString(82,microdados.getRP_006());
            	stm.setString(83,microdados.getRP_007());
            	stm.setString(84,microdados.getRP_008());
            	stm.setString(85,microdados.getRP_009());
            	stm.setString(86,microdados.getRP_010());
            	stm.setString(87,microdados.getRP_011());
            	stm.setString(88,microdados.getRP_012());
            	stm.setString(89,microdados.getRP_013());
            	stm.setString(90,microdados.getRP_014( ));
            	stm.setString(91,microdados.getRP_015( ));
            	stm.setString(92,microdados.getRP_016( ));
            	stm.setString(93,microdados.getRP_017( ));
            	stm.setString(94,microdados.getRP_018( ));
            	stm.setString(95,microdados.getRP_019( ));
            	stm.setString(96,microdados.getRP_020( ));
            	stm.setString(97,microdados.getRP_021( ));
            	stm.setString(98,microdados.getRP_022( ));
            	stm.setString(99,microdados.getRP_023( ));
            	stm.setString(100,microdados.getRP_024( ));
            	stm.setString(101,microdados.getRP_025( ));
            	stm.setString(102,microdados.getRP_026( ));
            	stm.setString(103,microdados.getRP_027( ));
            	stm.setString(104,microdados.getRP_028( ));
            	stm.setString(105,microdados.getRP_029( ));
            	stm.setString(106,microdados.getRP_030( ));
            	stm.setString(107,microdados.getRP_031( ));
            	stm.setString(108,microdados.getRP_032( ));
            	stm.setString(109,microdados.getRP_033( ));
            	stm.setString(110,microdados.getRP_034( ));
            	stm.setString(111,microdados.getRP_035( ));
            	stm.setString(112,microdados.getRP_036( ));
            	stm.setString(113,microdados.getRP_037( ));
            	stm.setString(114,microdados.getRP_038( ));
            	stm.setString(115,microdados.getRP_039( ));
            	stm.setString(116,microdados.getRP_040( ));
            	stm.setString(117,microdados.getRP_041( ));
            	stm.setString(118,microdados.getRP_042( ));
            	stm.setString(119,microdados.getRP_043( ));
            	stm.setString(120,microdados.getRP_044( ));
            	stm.setString(121,microdados.getRP_045( ));
            	stm.setString(122,microdados.getRP_046( ));
            	stm.setString(123,microdados.getRP_047( ));
            	stm.setString(124,microdados.getRP_048( ));
            	stm.setString(125,microdados.getRP_049( ));
            	stm.setString(126,microdados.getRP_050( ));
            	stm.setString(127,microdados.getRP_051( ));
            	stm.setString(128,microdados.getRP_052( ));
            	stm.setString(129,microdados.getRP_053( ));
            	stm.setString(130,microdados.getRP_054( ));
            	stm.setString(131,microdados.getRP_055( ));
            	stm.setString(132,microdados.getRP_056( ));
            	stm.setString(133,microdados.getRP_057( ));
            	stm.setString(134,microdados.getRP_059( ));
            	stm.setString(135,microdados.getRP_058( ));
            	
            	stm.setDouble(136,microdados.getRPA_001( ));
            	stm.setDouble(137,microdados.getRPA_002( ));
            	stm.setDouble(138,microdados.getRPA_003( ));
            	stm.setDouble(139,microdados.getRPA_004( ));
            	stm.setDouble(140,microdados.getRPA_005( ));
            	stm.setDouble(141,microdados.getRPA_006( ));
            	stm.setDouble(142,microdados.getRPA_007( ));
            	stm.setDouble(143,microdados.getRPA_008( ));
            	stm.setDouble(144,microdados.getRPA_009( ));
            	stm.setDouble(145,microdados.getRPA_010( ));
            	stm.setDouble(146,microdados.getRPA_011( ));
            	stm.setDouble(147,microdados.getRPA_012( ));
            	stm.setDouble(148,microdados.getRPA_013( ));
            	stm.setDouble(149,microdados.getRPA_014( ));
            	stm.setDouble(150,microdados.getRPA_015( ));
            	stm.setDouble(151,microdados.getRPA_016( ));
            	stm.setDouble(152,microdados.getRPA_017( ));
            	stm.setDouble(153,microdados.getRPA_018( ));
            	stm.setDouble(154,microdados.getRPA_019( ));
            	stm.setDouble(155,microdados.getRPA_020( ));
            	stm.setDouble(156,microdados.getRPA_021( ));
            	stm.setDouble(157,microdados.getRPA_022( ));
            	stm.setDouble(158,microdados.getRPA_023( ));
            	stm.setDouble(159,microdados.getRPA_024( ));
            	stm.setDouble(160,microdados.getRPA_025( ));
            	stm.setDouble(161,microdados.getRPA_026( ));
            	stm.setDouble(162,microdados.getRPA_027( ));
            	stm.setDouble(163,microdados.getRPA_028( ));
            	stm.setDouble(164,microdados.getRPA_029( ));
            	stm.setDouble(165,microdados.getRPA_030( ));
            	stm.setDouble(166,microdados.getRPA_031( ));
            	stm.setDouble(167,microdados.getRPA_032( ));
            	stm.setDouble(168,microdados.getRPA_033( ));
            	stm.setDouble(169,microdados.getRPA_034( ));
            	stm.setDouble(170,microdados.getRPA_035( ));
            	stm.setDouble(171,microdados.getRPA_036( ));
            	stm.setDouble(172,microdados.getRPA_037( ));
            	stm.setDouble(173,microdados.getRPA_038( ));
            	stm.setDouble(174,microdados.getRPA_039( ));
            	stm.setDouble(175,microdados.getRPA_040( ));
            	stm.setDouble(176,microdados.getRPA_041( ));
            	stm.setDouble(177,microdados.getRPA_042( ));
            	stm.setDouble(178,microdados.getRPA_043( ));
            	stm.setDouble(179,microdados.getRPA_044( ));
            	stm.setDouble(180,microdados.getRPA_045( ));
            	stm.setDouble(181,microdados.getRPA_046( ));
            	stm.setDouble(182,microdados.getRPA_047( ));
            	stm.setDouble(183,microdados.getRPA_048( ));
            	stm.setDouble(184,microdados.getRPA_049( ));
            	stm.setDouble(185,microdados.getRPA_050( ));
            	stm.setDouble(186,microdados.getRPA_051( ));
            	stm.setDouble(187,microdados.getRPA_052( ));
            	stm.setDouble(188,microdados.getRPA_053( ));
            	stm.setDouble(189,microdados.getRPA_054( ));
            	stm.setDouble(190,microdados.getRPA_055( ));
            	stm.setDouble(191,microdados.getRPA_056( ));
            	stm.setDouble(192,microdados.getRPA_057( ));
            	stm.setDouble(193,microdados.getRPA_058( ));
            	stm.setDouble(194,microdados.getRPA_059( ));
            	stm.setDouble(195,microdados.getRPA_060( ));
            	stm.setDouble(196,microdados.getRPA_061( ));
            	stm.setDouble(197,microdados.getRPA_062( ));
            	stm.setDouble(198,microdados.getRPA_063( ));
            	stm.setDouble(199,microdados.getRPA_064( ));
            	stm.setDouble(200,microdados.getRPA_065( ));
            	stm.setDouble(201,microdados.getRPA_066( ));
            	stm.setDouble(202,microdados.getRPA_067( ));
            	stm.setDouble(203,microdados.getRPA_068( ));
            	stm.setDouble(204,microdados.getRPA_069( ));
            	stm.setDouble(205,microdados.getRPA_070( ));
            	stm.setDouble(206,microdados.getRPA_071( ));
            	stm.setDouble(207,microdados.getRPA_072( ));
            	stm.setDouble(208,microdados.getRPA_073( ));
            	stm.setDouble(209,microdados.getRPA_074( ));
            	stm.setDouble(210,microdados.getRPA_075( ));
            	stm.setDouble(211,microdados.getRPA_076( ));
            	stm.setDouble(212,microdados.getRPA_077( ));
            	stm.setDouble(213,microdados.getRPA_078( ));
            	stm.setDouble(214,microdados.getRPA_079( ));
            	stm.setDouble(215,microdados.getRPA_080( ));
            	stm.setDouble(216,microdados.getRPA_081( ));
            	stm.setDouble(217,microdados.getRPA_082( ));
            	stm.setDouble(218,microdados.getRPA_083( ));
            	stm.setDouble(219,microdados.getRPA_084( ));
            	stm.setDouble(220,microdados.getRPA_085( ));
            	stm.setDouble(221,microdados.getRPA_086( ));
            	stm.setDouble(222,microdados.getRPA_087( ));
            	stm.setDouble(223,microdados.getRPA_088( ));
            	stm.setDouble(224,microdados.getRPA_089( ));
            	stm.setDouble(225,microdados.getRPA_090( ));
            	stm.setDouble(226,microdados.getRPA_091( ));
            	stm.setString(227,microdados.getNU_POSICAO_LISTA( ));
            	stm.setString(228,microdados.getRP_LISTA());
            	stm.setString(229,microdados.getDC_TURNO_ESCOLA());
            	stm.setDouble(230,microdados.getTIPO()==null?0:microdados.getTIPO());
            	stm.setDouble(231,microdados.getFL_ESC_TECNICA()==null?0:microdados.getFL_ESC_TECNICA());
            	stm.setDouble(232,microdados.getFL_SEAMA()==null?0:microdados.getFL_SEAMA());
            	stm.setDouble(233,microdados.getFL_SAEPE()==null?0:microdados.getFL_SAEPE());
            	stm.setDouble(234,microdados.getD001_ACERTO()==null?0:microdados.getD001_ACERTO());
            	stm.setDouble(235,microdados.getD001_TOTAL()==null?0:microdados.getD001_TOTAL());
            	stm.setDouble(236,microdados.getD002_ACERTO()==null?0:microdados.getD002_ACERTO());
            	stm.setDouble(237,microdados.getD002_TOTAL()==null?0:microdados.getD002_TOTAL());
            	stm.setDouble(238,microdados.getD003_ACERTO()==null?0:microdados.getD003_ACERTO());
            	stm.setDouble(239,microdados.getD003_TOTAL()==null?0:microdados.getD003_TOTAL());
            	stm.setDouble(240,microdados.getD004_ACERTO()==null?0:microdados.getD004_ACERTO());
            	stm.setDouble(241,microdados.getD004_TOTAL()==null?0:microdados.getD004_TOTAL());
            	stm.setDouble(242,microdados.getD005_ACERTO()==null?0:microdados.getD005_ACERTO());
            	stm.setDouble(243,microdados.getD005_TOTAL()==null?0:microdados.getD005_TOTAL());
            	stm.setDouble(244,microdados.getD007_ACERTO()==null?0:microdados.getD007_ACERTO());
            	stm.setDouble(245,microdados.getD007_TOTAL()==null?0:microdados.getD007_TOTAL());
            	stm.setDouble(246,microdados.getD008_ACERTO()==null?0:microdados.getD008_ACERTO());
            	stm.setDouble(247,microdados.getD008_TOTAL()==null?0:microdados.getD008_TOTAL());
            	stm.setDouble(248,microdados.getD009_ACERTO()==null?0:microdados.getD009_ACERTO());
            	stm.setDouble(249,microdados.getD009_TOTAL()==null?0:microdados.getD009_TOTAL());
            	stm.setDouble(250,microdados.getD010_ACERTO()==null?0:microdados.getD010_ACERTO());
            	stm.setDouble(251,microdados.getD010_TOTAL()==null?0:microdados.getD010_TOTAL());
            	stm.setDouble(252,microdados.getD011_ACERTO()==null?0:microdados.getD011_ACERTO());
            	stm.setDouble(253,microdados.getD011_TOTAL()==null?0:microdados.getD011_TOTAL());
            	stm.setDouble(254,microdados.getD012_ACERTO()==null?0:microdados.getD012_ACERTO());
            	stm.setDouble(255,microdados.getD012_TOTAL()==null?0:microdados.getD012_TOTAL());
            	stm.setDouble(256,microdados.getD013_ACERTO()==null?0:microdados.getD013_ACERTO());
            	stm.setDouble(257,microdados.getD013_TOTAL()==null?0:microdados.getD013_TOTAL());
            	stm.setDouble(258,microdados.getD014_ACERTO()==null?0:microdados.getD014_ACERTO());
            	stm.setDouble(259,microdados.getD014_TOTAL()==null?0:microdados.getD014_TOTAL());
            	stm.setDouble(260,microdados.getD015_ACERTO()==null?0:microdados.getD015_ACERTO());
            	stm.setDouble(261,microdados.getD015_TOTAL()==null?0:microdados.getD015_TOTAL());
            	
            	stm.setDouble(262,microdados.getD016_ACERTO()==null?0:microdados.getD016_ACERTO());            	
            	stm.setDouble(263,microdados.getD016_TOTAL()==null?0:microdados.getD016_TOTAL());
            	stm.setDouble(264,microdados.getD017_ACERTO()==null?0:microdados.getD017_ACERTO());
            	stm.setDouble(265,microdados.getD017_TOTAL()==null?0:microdados.getD017_TOTAL());
            	stm.setDouble(266,microdados.getD018_ACERTO()==null?0:microdados.getD018_ACERTO());
            	stm.setDouble(267,microdados.getD018_TOTAL()==null?0:microdados.getD018_TOTAL());
            	stm.setDouble(268,microdados.getD019_ACERTO()==null?0:microdados.getD019_ACERTO());
            	stm.setDouble(269,microdados.getD019_TOTAL()==null?0:microdados.getD019_TOTAL());
            	stm.setDouble(270,microdados.getD020_ACERTO()==null?0:microdados.getD020_ACERTO());
            	
            	stm.setDouble(271,microdados.getD020_TOTAL()==null?0:microdados.getD020_TOTAL());
            	stm.setDouble(272,microdados.getD021_ACERTO()==null?0:microdados.getD021_ACERTO());
            	stm.setDouble(273,microdados.getD021_TOTAL()==null?0:microdados.getD021_TOTAL());
            	stm.setDouble(274,microdados.getD022_ACERTO()==null?0:microdados.getD022_ACERTO());
            	stm.setDouble(275,microdados.getD022_TOTAL()==null?0:microdados.getD022_TOTAL());
            	stm.setDouble(276,microdados.getD023_ACERTO()==null?0:microdados.getD023_ACERTO());
            	stm.setDouble(277,microdados.getD023_TOTAL()==null?0:microdados.getD023_TOTAL());
            	stm.setDouble(278,microdados.getD024_ACERTO()==null?0:microdados.getD024_ACERTO());
            	stm.setDouble(279,microdados.getD024_TOTAL()==null?0:microdados.getD024_TOTAL());
            	stm.setDouble(280,microdados.getD025_ACERTO()==null?0:microdados.getD025_ACERTO());
            	stm.setDouble(281,microdados.getD025_TOTAL()==null?0:microdados.getD025_TOTAL());
            	stm.setDouble(282,microdados.getD026_ACERTO()==null?0:microdados.getD026_ACERTO());
            	stm.setDouble(283,microdados.getD026_TOTAL()==null?0:microdados.getD026_TOTAL());            	
            	stm.setString(284,microdados.getNM_ALUNO());

	         	
	         stm.execute();
	         stm.close();	         		
	         conex.close();
		
	}

	public void adicionaMicrodadosMP(MicrodadosMT microdados, int tamanho)  throws SQLException {
		// TODO Auto-generated method stub
		String sql2 = "insert into tb_microdados_matematica ("
				+ "cd_projeto,nu_ano,cd_estado,nm_estado,cd_regional,nm_regional,cd_municipio,nm_municipio,cd_escola,nm_escola,"
				+ "cd_rede,dc_rede,cd_localizacao,dc_localizacao,cd_turma,cd_turma_instituicao,nm_turma,cd_turno,dc_turno,fl_anexo_turma,"
				+ "cd_ensino,dc_ensino,cd_aluno,cd_aluno_institucional,cd_aluno_inep,cd_aluno_publicacao,nm_projeto,fl_multi_turma,"
				
				+ "dt_nascimento, cd_sexo, filiacao, dc_deficiencia, nm_disciplina_caderno, cd_disciplin, nm_disciplina, nm_disciplina_sigla, "
				+ "cd_etapa_aplicacao, dc_etapa_aplicacao, cd_etapa_avaliada, dc_etapa_avaliada, cd_etapa, cd_etapa_publicacao, dc_etapa_publicacao, cd_caderno, "
				+ "dc_caderno, nu_caderno, cd_base_versao, nu_sequencial, fl_filtros, dc_filtros, fl_plan_extra, fl_extra, fl_aln_extra, fl_publicacao, dc_publicacao, "
				+ "fl_excluido_planejada, fl_excluido_sujeito, fl_avaliado, fl_preenchido, vl_proficiencia, vl_proficiencia_erro, nu_pontos, vl_perc_acertos, id_mascara, "
				+ "cd_lote, nu_pacote, dc_imagem_cartao, dc_imagem_lista, dc_imagem_ata, dc_imagem_reserva, nu_imagem, id_instrumento, tp_instrumento, dc_desenho_instrumento, "
				+ "tp_processamento, rp, rp_001, rp_002, rp_003, rp_004, rp_005, rp_006, rp_007, rp_008, rp_009, rp_010, rp_011, rp_012, rp_013, rp_014, rp_015, rp_016, rp_017, "
				+ "rp_018, rp_019, rp_020, rp_021, rp_022, rp_023, rp_024, rp_025, rp_026, rp_027, rp_028, rp_029, rp_030, rp_031, rp_032, rp_033, rp_034, rp_035, rp_036, rp_037, "
				+ "rp_038, rp_039, rp_040, rp_041, rp_042, rp_043, rp_044, rp_045, rp_046, rp_047, rp_048, rp_049, rp_050, rp_051, rp_052, rp_053, rp_054, rp_055, rp_056, rp_057, "
				+ "rp_059, rp_058, rpa_001, rpa_002, rpa_003, rpa_004, rpa_005, rpa_006, rpa_007, rpa_008, rpa_009, rpa_010, rpa_011, rpa_012, rpa_013, rpa_014, rpa_015, rpa_016, "
				+ "rpa_017, rpa_018, rpa_019, rpa_020, rpa_021, rpa_022, rpa_023, rpa_024, rpa_025, rpa_026, rpa_027, rpa_028, rpa_029, rpa_030, rpa_031, rpa_032, rpa_033, rpa_034, "
				+ "rpa_035, rpa_036, rpa_037, rpa_038, rpa_039, rpa_040, rpa_041, rpa_042, rpa_043, rpa_044, rpa_045, rpa_046, rpa_047, rpa_048, rpa_049, rpa_050, rpa_051, rpa_052, "
				+ "rpa_053, rpa_054, rpa_055, rpa_056, rpa_057, rpa_058, rpa_059, rpa_060, rpa_061, rpa_062, rpa_063, rpa_064, rpa_065, rpa_066, rpa_067, rpa_068, rpa_069, rpa_070, "
				+ "rpa_071, rpa_072, rpa_073, rpa_074, rpa_075, rpa_076, rpa_077, rpa_078, rpa_079, rpa_080, rpa_081, rpa_082, rpa_083, rpa_084, rpa_085, rpa_086, rpa_087, rpa_088, "
				+ "rpa_089, rpa_090, rpa_091, nu_posicao_lista, rp_lista, dc_turno_escola, tipo, fl_esc_tecnica, fl_seama, fl_saepe, d001_acerto, d001_total, d002_acerto, d002_total, "
				+ "d003_acerto, d003_total, d004_acerto, d004_total, d005_acerto, d005_total, d007_acerto, d007_total, d008_acerto, d008_total, d009_acerto, d009_total, d010_acerto, "
				+ "d010_total, d011_acerto, d011_total, d012_acerto, d012_total, d013_acerto, d013_total, d014_acerto, d014_total, d015_acerto, d015_total, d016_acerto, d016_total, "
				+ "d017_acerto, d017_total, d018_acerto, d018_total, d019_acerto, d019_total, d020_acerto, d020_total, d021_acerto, d021_total, d022_acerto, d022_total, d023_acerto, "
				+ "d023_total, d024_acerto, d024_total, d025_acerto, d025_total, d026_acerto, d026_total,nm_aluno )" +
 	              " values (?,?,?,?,?,?,?,?,?,?,"
 	              + "		?,?,?,?,?,?,?,?,?,?,"
 	              + "		?,?,?,?,?,?,?,?,?,?, "
 	              + "		?,?,?,?,?,?,?,?,?,?,"
 	              + "       ?,?,?,?,?,?,?,?,?,?,"
 	              + "       ?,?,?,?,?,?,?,?,?,?,"
 	              + "		?,?,?,?,?,?,?,?,?,?, "
 	              + "		?,?,?,?,?,?,?,?,?,?, "
 	              + "		?,?,?,?,?,?,?,?,?,?, "
 	              + "		?,?,?,?,?,?,?,?,?,?, " //100
 	              
 	              + "?,?,?,?,?,?,?,?,?,?, "
 	              + "?,?,?,?,?,?,?,?,?,?, "
 	              + "?,?,?,?,?,?,?,?,?,?, "
 	              + "?,?,?,?,?,?,?,?,?,?, "
 	              + "?,?,?,?,?,?,?,?,?,?, "
 	              + "?,?,?,?,?,?,?,?,?,?, "
 	              + "?,?,?,?,?,?,?,?,?,?, "
 	              + "?,?,?,?,?,?,?,?,?,?, "
 	              + "?,?,?,?,?,?,?,?,?,?, "
 	              + "?,?,?,?,?,?,?,?,?,?, " //100
 	              
 	              + "?,?,?,?,?,?,?,?,?,?, "
 	              + "?,?,?,?,?,?,?,?,?,?, "
 	              + "?,?,?,?,?,?,?,?,?,?, "
 	              + "?,?,?,?,?,?,?,?,?,?, "
 	              + "?,?,?,?,?,?,?,?,?,?, "
 	              + "?,?,?,?,?,?,?,?,?,?, "
 	             + "?,?,?,?,?,?,?,?,?,?, "
 	            + "?,?,?,?,?,?,?,?,?,?, "
 	              + "?,?,?,?)"; //84
  		 Connection conex = getConnection();
	    	 PreparedStatement stm = conex.prepareStatement(sql2);
	         	stm.setDouble(1,microdados.getCD_PROJETO());
	         	stm.setDouble(2,microdados.getNU_ANO());
	         	stm.setDouble(3,microdados.getCD_ESTADO());
	         	stm.setString(4,microdados.getNM_ESTADO());
	         	stm.setString(5,microdados.getCD_REGIONAL());
	         	stm.setString(6,microdados.getNM_REGIONAL());
	         	stm.setDouble(7,microdados.getCD_MUNICIPIO());
	         	stm.setString(8,microdados.getNM_MUNICIPIO());
	         	stm.setDouble(9,microdados.getCD_ESCOLA());
	         	stm.setString(10,microdados.getNM_ESCOLA());
	         	stm.setDouble(11,microdados.getCD_REDE());
	         	stm.setString(12,microdados.getDC_REDE());
	         	stm.setDouble(13,microdados.getCD_LOCALIZACAO());
	         	stm.setString(14,microdados.getDC_LOCALIZACAO());
	         	stm.setDouble(15,microdados.getCD_TURMA());
	         	stm.setDouble(16,microdados.getCD_TURMA_INSTITUICAO());
	         	stm.setString(17,microdados.getNM_TURMA());
	         	stm.setDouble(18,microdados.getCD_TURNO());
	         	stm.setString(19,microdados.getDC_TURNO());
	         	stm.setDouble(20,microdados.getFL_ANEXO_TURMA());
	         	stm.setDouble(21,microdados.getCD_ENSINO());
	         	stm.setString(22,microdados.getDC_ENSINO());
	         	stm.setDouble(23,microdados.getCD_ALUNO());
	         	stm.setDouble(24,microdados.getCD_ALUNO_INSTITUCIONAL());
	         	stm.setDouble(25,microdados.getCD_ALUNO_INEP());
	         	stm.setDouble(26,microdados.getCD_ALUNO_PUBLICACAO());	         	
	         	stm.setString(27,microdados.getNM_PROJETO());
	         	stm.setDouble(28,microdados.getNU_ANO());
	         		         	
	         	stm.setString(29,microdados.getDT_NASCIMENTO());
	         	stm.setString(30,microdados.getCD_SEXO());
	         	stm.setString(31,microdados.getFILIACAO());
            	stm.setString(32,microdados.getDC_DEFICIENCIA());
            	stm.setString(33,microdados.getNM_DISCIPLINA_CADERNO());
            	stm.setDouble(34,microdados.getCD_DISCIPLIN());
            	stm.setString(35,microdados.getNM_DISCIPLINA());
            	stm.setString(36,microdados.getNM_DISCIPLINA_SIGLA());
            	stm.setDouble(37,microdados.getCD_ETAPA_APLICACAO());
            	stm.setString(38,microdados.getDC_ETAPA_APLICACAO());
            	stm.setDouble(39,microdados.getCD_ETAPA_AVALIADA());
            	stm.setString(40,microdados.getDC_ETAPA_AVALIADA());
            	stm.setDouble(41,microdados.getCD_ETAPA());
            	stm.setDouble(42,microdados.getCD_ETAPA_PUBLICACAO());
            	stm.setString(43,microdados.getDC_ETAPA_PUBLICACAO());
            	stm.setDouble(44,microdados.getCD_CADERNO());
            	stm.setString(45,microdados.getDC_CADERNO());
            	stm.setDouble(46,microdados.getNU_CADERNO());
            	stm.setDouble(47,microdados.getCD_BASE_VERSAO());
            	stm.setDouble(48,microdados.getNU_SEQUENCIAL());
            	stm.setDouble(49,microdados.getFL_FILTROS());
            	stm.setString(50,microdados.getDC_FILTROS());
            	stm.setDouble(51,microdados.getFL_PLAN_EXTRA());
            	stm.setDouble(52,microdados.getFL_EXTRA());
            	stm.setDouble(53,microdados.getFL_ALN_EXTRA());
            	stm.setDouble(54,microdados.getFL_PUBLICACAO());
            	stm.setString(55,microdados.getDC_PUBLICACAO());
            	stm.setString(56,microdados.getFL_EXCLUIDO_PLANEJADA());
            	stm.setString(57,microdados.getFL_EXCLUIDO_SUJEITO());
            	stm.setDouble(58,microdados.getFL_AVALIADO());
            	stm.setDouble(59,microdados.getFL_PREENCHIDO());
            	stm.setString(60,microdados.getVL_PROFICIENCIA());
            	stm.setDouble(61,microdados.getVL_PROFICIENCIA_ERRO());
            	stm.setDouble(62,microdados.getNU_PONTOS());
            	stm.setDouble(63,microdados.getVL_PERC_ACERTOS());
            	stm.setDouble(64,microdados.getID_MASCARA());
            	stm.setDouble(65,microdados.getCD_LOTE());
            	stm.setDouble(66,microdados.getNU_PACOTE());
            	stm.setString(67,microdados.getDC_IMAGEM_CARTAO());
            	stm.setString(68,microdados.getDC_IMAGEM_LISTA());
            	stm.setString(69,microdados.getDC_IMAGEM_ATA());
            	stm.setString(70,microdados.getDC_IMAGEM_RESERVA());
            	stm.setString(71,microdados.getNU_IMAGEM());
            	stm.setString(72,microdados.getID_INSTRUMENTO());
            	stm.setString(73,microdados.getTP_INSTRUMENTO());
            	stm.setString(74,microdados.getDC_DESENHO_INSTRUMENTO());
            	stm.setString(75,microdados.getTP_PROCESSAMENTO());
            	stm.setString(76,microdados.getRP());
            	stm.setString(77,microdados.getRP_001());
            	stm.setString(78,microdados.getRP_002());
            	stm.setString(79,microdados.getRP_003());
            	stm.setString(80,microdados.getRP_004());
            	stm.setString(81,microdados.getRP_005());
            	stm.setString(82,microdados.getRP_006());
            	stm.setString(83,microdados.getRP_007());
            	stm.setString(84,microdados.getRP_008());
            	stm.setString(85,microdados.getRP_009());
            	stm.setString(86,microdados.getRP_010());
            	stm.setString(87,microdados.getRP_011());
            	stm.setString(88,microdados.getRP_012());
            	stm.setString(89,microdados.getRP_013());
            	stm.setString(90,microdados.getRP_014( ));
            	stm.setString(91,microdados.getRP_015( ));
            	stm.setString(92,microdados.getRP_016( ));
            	stm.setString(93,microdados.getRP_017( ));
            	stm.setString(94,microdados.getRP_018( ));
            	stm.setString(95,microdados.getRP_019( ));
            	stm.setString(96,microdados.getRP_020( ));
            	stm.setString(97,microdados.getRP_021( ));
            	stm.setString(98,microdados.getRP_022( ));
            	stm.setString(99,microdados.getRP_023( ));
            	stm.setString(100,microdados.getRP_024( ));
            	stm.setString(101,microdados.getRP_025( ));
            	stm.setString(102,microdados.getRP_026( ));
            	stm.setString(103,microdados.getRP_027( ));
            	stm.setString(104,microdados.getRP_028( ));
            	stm.setString(105,microdados.getRP_029( ));
            	stm.setString(106,microdados.getRP_030( ));
            	stm.setString(107,microdados.getRP_031( ));
            	stm.setString(108,microdados.getRP_032( ));
            	stm.setString(109,microdados.getRP_033( ));
            	stm.setString(110,microdados.getRP_034( ));
            	stm.setString(111,microdados.getRP_035( ));
            	stm.setString(112,microdados.getRP_036( ));
            	stm.setString(113,microdados.getRP_037( ));
            	stm.setString(114,microdados.getRP_038( ));
            	stm.setString(115,microdados.getRP_039( ));
            	stm.setString(116,microdados.getRP_040( ));
            	stm.setString(117,microdados.getRP_041( ));
            	stm.setString(118,microdados.getRP_042( ));
            	stm.setString(119,microdados.getRP_043( ));
            	stm.setString(120,microdados.getRP_044( ));
            	stm.setString(121,microdados.getRP_045( ));
            	stm.setString(122,microdados.getRP_046( ));
            	stm.setString(123,microdados.getRP_047( ));
            	stm.setString(124,microdados.getRP_048( ));
            	stm.setString(125,microdados.getRP_049( ));
            	stm.setString(126,microdados.getRP_050( ));
            	stm.setString(127,microdados.getRP_051( ));
            	stm.setString(128,microdados.getRP_052( ));
            	stm.setString(129,microdados.getRP_053( ));
            	stm.setString(130,microdados.getRP_054( ));
            	stm.setString(131,microdados.getRP_055( ));
            	stm.setString(132,microdados.getRP_056( ));
            	stm.setString(133,microdados.getRP_057( ));
            	stm.setString(134,microdados.getRP_059( ));
            	stm.setString(135,microdados.getRP_058( ));
            	
            	stm.setDouble(136,microdados.getRPA_001( ));
            	stm.setDouble(137,microdados.getRPA_002( ));
            	stm.setDouble(138,microdados.getRPA_003( ));
            	stm.setDouble(139,microdados.getRPA_004( ));
            	stm.setDouble(140,microdados.getRPA_005( ));
            	stm.setDouble(141,microdados.getRPA_006( ));
            	stm.setDouble(142,microdados.getRPA_007( ));
            	stm.setDouble(143,microdados.getRPA_008( ));
            	stm.setDouble(144,microdados.getRPA_009( ));
            	stm.setDouble(145,microdados.getRPA_010( ));
            	stm.setDouble(146,microdados.getRPA_011( ));
            	stm.setDouble(147,microdados.getRPA_012( ));
            	stm.setDouble(148,microdados.getRPA_013( ));
            	stm.setDouble(149,microdados.getRPA_014( ));
            	stm.setDouble(150,microdados.getRPA_015( ));
            	stm.setDouble(151,microdados.getRPA_016( ));
            	stm.setDouble(152,microdados.getRPA_017( ));
            	stm.setDouble(153,microdados.getRPA_018( ));
            	stm.setDouble(154,microdados.getRPA_019( ));
            	stm.setDouble(155,microdados.getRPA_020( ));
            	stm.setDouble(156,microdados.getRPA_021( ));
            	stm.setDouble(157,microdados.getRPA_022( ));
            	stm.setDouble(158,microdados.getRPA_023( ));
            	stm.setDouble(159,microdados.getRPA_024( ));
            	stm.setDouble(160,microdados.getRPA_025( ));
            	stm.setDouble(161,microdados.getRPA_026( ));
            	stm.setDouble(162,microdados.getRPA_027( ));
            	stm.setDouble(163,microdados.getRPA_028( ));
            	stm.setDouble(164,microdados.getRPA_029( ));
            	stm.setDouble(165,microdados.getRPA_030( ));
            	stm.setDouble(166,microdados.getRPA_031( ));
            	stm.setDouble(167,microdados.getRPA_032( ));
            	stm.setDouble(168,microdados.getRPA_033( ));
            	stm.setDouble(169,microdados.getRPA_034( ));
            	stm.setDouble(170,microdados.getRPA_035( ));
            	stm.setDouble(171,microdados.getRPA_036( ));
            	stm.setDouble(172,microdados.getRPA_037( ));
            	stm.setDouble(173,microdados.getRPA_038( ));
            	stm.setDouble(174,microdados.getRPA_039( ));
            	stm.setDouble(175,microdados.getRPA_040( ));
            	stm.setDouble(176,microdados.getRPA_041( ));
            	stm.setDouble(177,microdados.getRPA_042( ));
            	stm.setDouble(178,microdados.getRPA_043( ));
            	stm.setDouble(179,microdados.getRPA_044( ));
            	stm.setDouble(180,microdados.getRPA_045( ));
            	stm.setDouble(181,microdados.getRPA_046( ));
            	stm.setDouble(182,microdados.getRPA_047( ));
            	stm.setDouble(183,microdados.getRPA_048( ));
            	stm.setDouble(184,microdados.getRPA_049( ));
            	stm.setDouble(185,microdados.getRPA_050( ));
            	stm.setDouble(186,microdados.getRPA_051( ));
            	stm.setDouble(187,microdados.getRPA_052( ));
            	stm.setDouble(188,microdados.getRPA_053( ));
            	stm.setDouble(189,microdados.getRPA_054( ));
            	stm.setDouble(190,microdados.getRPA_055( ));
            	stm.setDouble(191,microdados.getRPA_056( ));
            	stm.setDouble(192,microdados.getRPA_057( ));
            	stm.setDouble(193,microdados.getRPA_058( ));
            	stm.setDouble(194,microdados.getRPA_059( ));
            	stm.setDouble(195,microdados.getRPA_060( ));
            	stm.setDouble(196,microdados.getRPA_061( ));
            	stm.setDouble(197,microdados.getRPA_062( ));
            	stm.setDouble(198,microdados.getRPA_063( ));
            	stm.setDouble(199,microdados.getRPA_064( ));
            	stm.setDouble(200,microdados.getRPA_065( ));
            	stm.setDouble(201,microdados.getRPA_066( ));
            	stm.setDouble(202,microdados.getRPA_067( ));
            	stm.setDouble(203,microdados.getRPA_068( ));
            	stm.setDouble(204,microdados.getRPA_069( ));
            	stm.setDouble(205,microdados.getRPA_070( ));
            	stm.setDouble(206,microdados.getRPA_071( ));
            	stm.setDouble(207,microdados.getRPA_072( ));
            	stm.setDouble(208,microdados.getRPA_073( ));
            	stm.setDouble(209,microdados.getRPA_074( ));
            	stm.setDouble(210,microdados.getRPA_075( ));
            	stm.setDouble(211,microdados.getRPA_076( ));
            	stm.setDouble(212,microdados.getRPA_077( ));
            	stm.setDouble(213,microdados.getRPA_078( ));
            	stm.setDouble(214,microdados.getRPA_079( ));
            	stm.setDouble(215,microdados.getRPA_080( ));
            	stm.setDouble(216,microdados.getRPA_081( ));
            	stm.setDouble(217,microdados.getRPA_082( ));
            	stm.setDouble(218,microdados.getRPA_083( ));
            	stm.setDouble(219,microdados.getRPA_084( ));
            	stm.setDouble(220,microdados.getRPA_085( ));
            	stm.setDouble(221,microdados.getRPA_086( ));
            	stm.setDouble(222,microdados.getRPA_087( ));
            	stm.setDouble(223,microdados.getRPA_088( ));
            	stm.setDouble(224,microdados.getRPA_089( ));
            	stm.setDouble(225,microdados.getRPA_090( ));
            	stm.setDouble(226,microdados.getRPA_091( ));
            	stm.setString(227,microdados.getNU_POSICAO_LISTA( ));
            	stm.setString(228,microdados.getRP_LISTA());
            	stm.setString(229,microdados.getDC_TURNO_ESCOLA());
            	stm.setDouble(230,microdados.getTIPO());
            	stm.setDouble(231,microdados.getFL_ESC_TECNICA());
            	stm.setDouble(232,microdados.getFL_SEAMA()==null?0:microdados.getFL_SEAMA());
            	stm.setDouble(233,microdados.getFL_SAEPE()==null?0:microdados.getFL_SAEPE());
            	stm.setDouble(234,microdados.getD001_ACERTO()==null?0:microdados.getD001_ACERTO());
            	stm.setDouble(235,microdados.getD001_TOTAL()==null?0:microdados.getD001_TOTAL());
            	stm.setDouble(236,microdados.getD002_ACERTO()==null?0:microdados.getD002_ACERTO());
            	stm.setDouble(237,microdados.getD002_TOTAL()==null?0:microdados.getD002_TOTAL());
            	stm.setDouble(238,microdados.getD003_ACERTO()==null?0:microdados.getD003_ACERTO());
            	stm.setDouble(239,microdados.getD003_TOTAL()==null?0:microdados.getD003_TOTAL());
            	stm.setDouble(240,microdados.getD004_ACERTO()==null?0:microdados.getD004_ACERTO());
            	stm.setDouble(241,microdados.getD004_TOTAL()==null?0:microdados.getD004_TOTAL());
            	stm.setDouble(242,microdados.getD005_ACERTO()==null?0:microdados.getD005_ACERTO());
            	stm.setDouble(243,microdados.getD005_TOTAL()==null?0:microdados.getD005_TOTAL());
            	stm.setDouble(244,microdados.getD007_ACERTO()==null?0:microdados.getD007_ACERTO());
            	stm.setDouble(245,microdados.getD007_TOTAL()==null?0:microdados.getD007_TOTAL());
            	stm.setDouble(246,microdados.getD008_ACERTO()==null?0:microdados.getD008_ACERTO());
            	stm.setDouble(247,microdados.getD008_TOTAL()==null?0:microdados.getD008_TOTAL());
            	stm.setDouble(248,microdados.getD009_ACERTO()==null?0:microdados.getD009_ACERTO());
            	stm.setDouble(249,microdados.getD009_TOTAL()==null?0:microdados.getD009_TOTAL());
            	stm.setDouble(250,microdados.getD010_ACERTO()==null?0:microdados.getD010_ACERTO());
            	stm.setDouble(251,microdados.getD010_TOTAL()==null?0:microdados.getD010_TOTAL());
            	stm.setDouble(252,microdados.getD011_ACERTO()==null?0:microdados.getD011_ACERTO());
            	stm.setDouble(253,microdados.getD011_TOTAL()==null?0:microdados.getD011_TOTAL());
            	stm.setDouble(254,microdados.getD012_ACERTO()==null?0:microdados.getD012_ACERTO());
            	stm.setDouble(255,microdados.getD012_TOTAL()==null?0:microdados.getD012_TOTAL());
            	stm.setDouble(256,microdados.getD013_ACERTO()==null?0:microdados.getD013_ACERTO());
            	stm.setDouble(257,microdados.getD013_TOTAL()==null?0:microdados.getD013_TOTAL());
            	stm.setDouble(258,microdados.getD014_ACERTO()==null?0:microdados.getD014_ACERTO());
            	stm.setDouble(259,microdados.getD014_TOTAL()==null?0:microdados.getD014_TOTAL());
            	stm.setDouble(260,microdados.getD015_ACERTO()==null?0:microdados.getD015_ACERTO());
            	stm.setDouble(261,microdados.getD015_TOTAL()==null?0:microdados.getD015_TOTAL());
            	stm.setDouble(262,microdados.getD016_ACERTO()==null?0:microdados.getD016_ACERTO());
            	
            	stm.setDouble(263,microdados.getD016_TOTAL()==null?0:microdados.getD016_TOTAL());
            	stm.setDouble(264,microdados.getD017_ACERTO()==null?0:microdados.getD017_ACERTO());
            	stm.setDouble(265,microdados.getD017_TOTAL()==null?0:microdados.getD017_TOTAL());
            	stm.setDouble(266,microdados.getD018_ACERTO()==null?0:microdados.getD018_ACERTO());
            	stm.setDouble(267,microdados.getD018_TOTAL()==null?0:microdados.getD018_TOTAL());
            	stm.setDouble(268,microdados.getD019_ACERTO()==null?0:microdados.getD019_ACERTO());
            	stm.setDouble(269,microdados.getD019_TOTAL()==null?0:microdados.getD019_TOTAL());
            	stm.setDouble(270,microdados.getD020_ACERTO()==null?0:microdados.getD020_ACERTO());
            	
            	stm.setDouble(271,microdados.getD020_TOTAL()==null?0:microdados.getD020_TOTAL());
            	stm.setDouble(272,microdados.getD021_ACERTO()==null?0:microdados.getD021_ACERTO());
            	stm.setDouble(273,microdados.getD021_TOTAL()==null?0:microdados.getD021_TOTAL());
            	stm.setDouble(274,microdados.getD022_ACERTO()==null?0:microdados.getD022_ACERTO());
            	stm.setDouble(275,microdados.getD022_TOTAL()==null?0:microdados.getD022_TOTAL());
            	stm.setDouble(276,microdados.getD023_ACERTO()==null?0:microdados.getD023_ACERTO());
            	stm.setDouble(277,microdados.getD023_TOTAL()==null?0:microdados.getD023_TOTAL());
            	stm.setDouble(278,microdados.getD024_ACERTO()==null?0:microdados.getD024_ACERTO());
            	stm.setDouble(279,microdados.getD024_TOTAL()==null?0:microdados.getD024_TOTAL() );
            	stm.setDouble(280,microdados.getD025_ACERTO()==null?0:microdados.getD025_ACERTO());
            	stm.setDouble(281,microdados.getD025_TOTAL()==null?0:microdados.getD025_TOTAL());
            	stm.setDouble(282,microdados.getD026_ACERTO()==null?0:microdados.getD026_ACERTO());
            	stm.setDouble(283,microdados.getD026_TOTAL()==null?0:microdados.getD026_TOTAL());            	
            	stm.setString(284,microdados.getNM_ALUNO());

	         	
	         stm.execute();
	         stm.close();	         		
	         conex.close();

	}
        
}
