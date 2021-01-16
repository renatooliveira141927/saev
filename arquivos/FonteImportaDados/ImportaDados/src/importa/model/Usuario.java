package importa.model;

public class Usuario {
	private Integer ci_usuario; 
	private String nm_usuario;
	private String nm_login;
	private String ds_senha;
	public Integer getCi_usuario() {
		return ci_usuario;
	}
	public void setCi_usuario(Integer ci_usuario) {
		this.ci_usuario = ci_usuario;
	}
	public String getNm_usuario() {
		return nm_usuario;
	}
	public void setNm_usuario(String nm_usuario) {
		this.nm_usuario = nm_usuario;
	}
	public String getNm_login() {
		return nm_login;
	}
	public void setNm_login(String nm_login) {
		this.nm_login = nm_login;
	}
	public String getDs_senha() {
		return ds_senha;
	}
	public void setDs_senha(String ds_senha) {
		this.ds_senha = ds_senha;
	}
	@Override
	public int hashCode() {
		final int prime = 31;
		int result = 1;
		result = prime * result + ((ci_usuario == null) ? 0 : ci_usuario.hashCode());
		result = prime * result + ((ds_senha == null) ? 0 : ds_senha.hashCode());
		result = prime * result + ((nm_login == null) ? 0 : nm_login.hashCode());
		result = prime * result + ((nm_usuario == null) ? 0 : nm_usuario.hashCode());
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
		Usuario other = (Usuario) obj;
		if (ci_usuario == null) {
			if (other.ci_usuario != null)
				return false;
		} else if (!ci_usuario.equals(other.ci_usuario))
			return false;
		if (ds_senha == null) {
			if (other.ds_senha != null)
				return false;
		} else if (!ds_senha.equals(other.ds_senha))
			return false;
		if (nm_login == null) {
			if (other.nm_login != null)
				return false;
		} else if (!nm_login.equals(other.nm_login))
			return false;
		if (nm_usuario == null) {
			if (other.nm_usuario != null)
				return false;
		} else if (!nm_usuario.equals(other.nm_usuario))
			return false;
		return true;
	}
	
}
