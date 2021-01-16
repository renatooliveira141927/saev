package importa.model;

import java.util.Date;

public class Turma {
	private Integer ci_turma;
	private String nm_turma;
	private Integer cd_escola;
	private Integer cd_etapa;
	private Integer cd_turno;
	private Boolean fl_ativo;
	private Integer cd_usuario_cad;
	private Date dt_cadastro;
	private String tp_turma;
	private Integer nr_ano_letivo;
	
	public Integer getCi_turma() {
		return ci_turma;
	}
	public void setCi_turma(Integer ci_turma) {
		this.ci_turma = ci_turma;
	}
	public String getNm_turma() {
		return nm_turma;
	}
	public void setNm_turma(String nm_turma) {
		this.nm_turma = nm_turma;
	}
	public Integer getCd_escola() {
		return cd_escola;
	}
	public void setCd_escola(Integer cd_escola) {
		this.cd_escola = cd_escola;
	}
	public Integer getCd_etapa() {
		return cd_etapa;
	}
	public void setCd_etapa(Integer cd_etapa) {
		this.cd_etapa = cd_etapa;
	}
	public Integer getCd_turno() {
		return cd_turno;
	}
	public void setCd_turno(Integer cd_turno) {
		this.cd_turno = cd_turno;
	}
	public Boolean getFl_ativo() {
		return fl_ativo;
	}
	public void setFl_ativo(Boolean fl_ativo) {
		this.fl_ativo = fl_ativo;
	}
	public Integer getCd_usuario_cad() {
		return cd_usuario_cad;
	}
	public void setCd_usuario_cad(Integer cd_usuario_cad) {
		this.cd_usuario_cad = cd_usuario_cad;
	}
	public Date getDt_cadastro() {
		return dt_cadastro;
	}
	public void setDt_cadastro(Date dt_cadastro) {
		this.dt_cadastro = dt_cadastro;
	}
	public String getTp_turma() {
		return tp_turma;
	}
	public void setTp_turma(String tp_turma) {
		this.tp_turma = tp_turma;
	}
	public Integer getNr_ano_letivo() {
		return nr_ano_letivo;
	}
	public void setNr_ano_letivo(Integer nr_ano_letivo) {
		this.nr_ano_letivo = nr_ano_letivo;
	}
	@Override
	public int hashCode() {
		final int prime = 31;
		int result = 1;
		result = prime * result + ((cd_escola == null) ? 0 : cd_escola.hashCode());
		result = prime * result + ((cd_etapa == null) ? 0 : cd_etapa.hashCode());
		result = prime * result + ((cd_turno == null) ? 0 : cd_turno.hashCode());
		result = prime * result + ((nm_turma == null) ? 0 : nm_turma.hashCode());
		result = prime * result + ((nr_ano_letivo == null) ? 0 : nr_ano_letivo.hashCode());
		result = prime * result + ((tp_turma == null) ? 0 : tp_turma.hashCode());
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
		Turma other = (Turma) obj;
		if (cd_escola == null) {
			if (other.cd_escola != null)
				return false;
		} else if (!cd_escola.equals(other.cd_escola))
			return false;
		if (cd_etapa == null) {
			if (other.cd_etapa != null)
				return false;
		} else if (!cd_etapa.equals(other.cd_etapa))
			return false;
		if (cd_turno == null) {
			if (other.cd_turno != null)
				return false;
		} else if (!cd_turno.equals(other.cd_turno))
			return false;
		if (nm_turma == null) {
			if (other.nm_turma != null)
				return false;
		} else if (!nm_turma.equals(other.nm_turma))
			return false;
		if (nr_ano_letivo == null) {
			if (other.nr_ano_letivo != null)
				return false;
		} else if (!nr_ano_letivo.equals(other.nr_ano_letivo))
			return false;
		if (tp_turma == null) {
			if (other.tp_turma != null)
				return false;
		} else if (!tp_turma.equals(other.tp_turma))
			return false;
		return true;
	}
	
}
