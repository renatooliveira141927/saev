package importa.model;

public class Etapa {
	
	private Integer ci_etapa;
	private String nm_etapa;
	private Boolean fl_ativo;
	private Integer cd_usuario_cad;
	public Integer getCi_etapa() {
		return ci_etapa;
	}
	public void setCi_etapa(Integer ci_etapa) {
		this.ci_etapa = ci_etapa;
	}
	public String getNm_etapa() {
		return nm_etapa;
	}
	public void setNm_etapa(String nm_etapa) {
		this.nm_etapa = nm_etapa;
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
	@Override
	public int hashCode() {
		final int prime = 31;
		int result = 1;
		result = prime * result + ((ci_etapa == null) ? 0 : ci_etapa.hashCode());
		result = prime * result + ((nm_etapa == null) ? 0 : nm_etapa.hashCode());
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
		Etapa other = (Etapa) obj;
		if (ci_etapa == null) {
			if (other.ci_etapa != null)
				return false;
		} else if (!ci_etapa.equals(other.ci_etapa))
			return false;
		if (nm_etapa == null) {
			if (other.nm_etapa != null)
				return false;
		} else if (!nm_etapa.equals(other.nm_etapa))
			return false;
		return true;
	}
	
}
