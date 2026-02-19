package gr.uowm.iroom.security;

import gr.uowm.iroom.entity.Admin;
import gr.uowm.iroom.entity.User;
import lombok.AllArgsConstructor;
import lombok.Data;
import org.springframework.security.core.GrantedAuthority;
import org.springframework.security.core.authority.SimpleGrantedAuthority;
import org.springframework.security.core.userdetails.UserDetails;

import java.util.Collection;
import java.util.Collections;

@Data
@AllArgsConstructor
public class UserPrincipal implements UserDetails {
    private Long id;
    private String email;
    private String password;
    private String userType;
    private Collection<? extends GrantedAuthority> authorities;

    public static UserPrincipal create(User user, String password) {
        return new UserPrincipal(
            user.getId(),
            user.getEmail(),
            password,
            user.getUserType(),
            Collections.singletonList(new SimpleGrantedAuthority("ROLE_" + mapUserType(user.getUserType())))
        );
    }

    public static UserPrincipal create(Admin admin) {
        return new UserPrincipal(
            admin.getId(),
            admin.getEmail(),
            admin.getPasswordHash(),
            "Διαχειριστής",
            Collections.singletonList(new SimpleGrantedAuthority("ROLE_ADMIN"))
        );
    }

    private static String mapUserType(String userType) {
        return switch (userType) {
            case "Καθηγητής" -> "PROFESSOR";
            case "Φοιτητής" -> "STUDENT";
            case "Γραμματεία" -> "SECRETARIAT";
            case "Διαχειριστής" -> "ADMIN";
            default -> "USER";
        };
    }

    @Override
    public String getUsername() {
        return email;
    }

    @Override
    public boolean isAccountNonExpired() {
        return true;
    }

    @Override
    public boolean isAccountNonLocked() {
        return true;
    }

    @Override
    public boolean isCredentialsNonExpired() {
        return true;
    }

    @Override
    public boolean isEnabled() {
        return true;
    }
}
