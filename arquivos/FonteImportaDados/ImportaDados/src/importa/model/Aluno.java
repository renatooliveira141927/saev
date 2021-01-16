package importa.model;

import java.sql.Date;

public class Aluno {
	
	private Integer ci_aluno;
	private Integer cd_escola;
	private String nm_escola;
	private String nr_inep;
	private String nm_aluno;
        private Integer cd_cidade;
	private Date dt_nascimento;
	private Boolean fl_ativo;
	private Integer cd_usuario_cad;
	
	public Integer getCi_aluno() {
		return ci_aluno;
	}
	public void setCi_aluno(Integer ci_aluno) {
		this.ci_aluno = ci_aluno;
	}
	
	public String getNm_escola() {
		return nm_escola;
	}
	public void setNm_escola(String nm_escola) {
		this.nm_escola = nm_escola;
	}
	public Integer getCd_escola() {
		return cd_escola;
	}
	public void setCd_escola(Integer cd_escola) {
		this.cd_escola = cd_escola;
	}
	public String getNr_inep() {
		return nr_inep;
	}
	public void setNr_inep(String nr_inep) {
		this.nr_inep = nr_inep;
	}
	public String getNm_aluno() {
		return nm_aluno;
	}
	public void setNm_aluno(String nm_aluno) {
		this.nm_aluno = nm_aluno;
	}
	public Date getDt_nascimento() {
		return dt_nascimento;
	}
	public void setDt_nascimento(Date dt_nascimento) {
		this.dt_nascimento = dt_nascimento;
	}
        public void setCd_cidade(Integer cd_cidade){
            this.cd_cidade=cd_cidade;
        }
        public Integer getCd_cidade(){
               return this.cd_cidade; 
        }
        
	public Integer getCd_usuario_cad() {
		return cd_usuario_cad;
	}
	public void setCd_usuario_cad(Integer cd_usuario_cad) {
		this.cd_usuario_cad = cd_usuario_cad;
	}
	public Boolean getFl_ativo() {
		return fl_ativo;
	}
	public void setFl_ativo(Boolean fl_ativo) {
		this.fl_ativo = fl_ativo;
	}
	@Override
	public int hashCode() {
		final int prime = 31;
		int result = 1;
		result = prime * result + ((cd_escola == null) ? 0 : cd_escola.hashCode());
		result = prime * result + ((nm_aluno == null) ? 0 : nm_aluno.hashCode());
		result = prime * result + ((nr_inep == null) ? 0 : nr_inep.hashCode());
		return result;
	}
	@Override
	public boolean equals(Object obj) {
		if (this == obj)
			return true;
		if (obj == null)
			return false;
		if (getClass() != obj.getClass())
			return false;
		Aluno other = (Aluno) obj;
		if (cd_escola == null) {
			if (other.cd_escola != null)
				return false;
		} else if (!cd_escola.equals(other.cd_escola))
			return false;		
		if (nm_aluno == null) {
			if (other.nm_aluno != null)
				return false;
		} else if (!nm_aluno.equals(other.nm_aluno))
			return false;
		if (nr_inep == null) {
			if (other.nr_inep != null)
				return false;
		} else if (!nr_inep.equals(other.nr_inep))
			return false;
		return true;
	}
	
}
