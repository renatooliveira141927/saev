package importa.model;

public class Escola {

	private Integer id;	
	private String nr_inep;
	private String nm_escola;	
	private Integer cd_cidade;	
	private Boolean fl_ativo;
	private Integer cd_usuario_cad;
	
	public Integer getId() {
		return id;
	}
	public void setId(Integer id) {
		this.id = id;
	}
	public String getNr_inep() {
		return nr_inep;
	}
	public void setNr_inep(String nr_inep) {
		this.nr_inep = nr_inep;
	}
	public String getNm_escola() {
		return nm_escola;
	}
	public void setNm_escola(String nm_escola) {
		this.nm_escola = nm_escola;
	}
	public Integer getCd_cidade() {
		return cd_cidade;
	}
	public void setCd_cidade(Integer cd_cidade) {
		this.cd_cidade = cd_cidade;
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
		result = prime * result + ((nm_escola == null) ? 0 : nm_escola.hashCode());
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
		Escola other = (Escola) obj;
		if (nm_escola == null) {
			if (other.nm_escola != null)
				return false;
		} else if (!nm_escola.equals(other.nm_escola))
			return false;
		if (nr_inep == null) {
			if (other.nr_inep != null)
				return false;
		} else if (!nr_inep.equals(other.nr_inep))
			return false;
		return true;
	}
	
}
