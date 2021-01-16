package importa.model;

public class Enturmacao {
	
	private Integer ci_enturmacao;
	private Integer cd_aluno;
	private Integer cd_turma;	
	private Integer cd_usuario_cad;
	private Boolean fl_ativo;
        private String escolaEnturmacao;
        private String turmaEnturmacao;
        private String alunoEnturmacao;
	
	public Integer getCi_enturmacao() {
		return ci_enturmacao;
	}
	public void setCi_enturmacao(Integer ci_enturmacao) {
		this.ci_enturmacao = ci_enturmacao;
	}
	public Integer getCd_aluno() {
		return cd_aluno;
	}
	public void setCd_aluno(Integer cd_aluno) {
		this.cd_aluno = cd_aluno;
	}
	public Integer getCd_turma() {
		return cd_turma;
	}
	public void setCd_turma(Integer cd_turma) {
		this.cd_turma = cd_turma;
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
        
        public String getEscolaEnturmacao() {
           return escolaEnturmacao;
        }

        public void setEscolaEnturmacao(String escolaEnturmacao) {
            this.escolaEnturmacao = escolaEnturmacao;
        }

        public String getTurmaEnturmacao() {
            return turmaEnturmacao;
        }

        public void setTurmaEnturmacao(String turmaEnturmacao) {
            this.turmaEnturmacao = turmaEnturmacao;
        }
        
        public String getAlunoEnturmacao() {
            return alunoEnturmacao;
        }

        public void setAlunoEnturmacao(String alunoEnturmacao) {
            this.alunoEnturmacao = alunoEnturmacao;
        }
        
	@Override
	public int hashCode() {
		final int prime = 31;
		int result = 1;
		result = prime * result + ((cd_aluno == null) ? 0 : cd_aluno.hashCode());
		result = prime * result + ((cd_turma == null) ? 0 : cd_turma.hashCode());		
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
		Enturmacao other = (Enturmacao) obj;
		if (cd_aluno == null) {
			if (other.cd_aluno != null)
				return false;
		} else if (!cd_aluno.equals(other.cd_aluno))
			return false;
		if (cd_turma == null) {
			if (other.cd_turma != null)
				return false;
		} else if (!cd_turma.equals(other.cd_turma))
			return false;		
		return true;
	}
	
}
