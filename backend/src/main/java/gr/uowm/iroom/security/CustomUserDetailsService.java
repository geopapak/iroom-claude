package gr.uowm.iroom.security;

import gr.uowm.iroom.entity.Admin;
import gr.uowm.iroom.entity.Password;
import gr.uowm.iroom.entity.User;
import gr.uowm.iroom.repository.AdminRepository;
import gr.uowm.iroom.repository.PasswordRepository;
import gr.uowm.iroom.repository.UserRepository;
import lombok.RequiredArgsConstructor;
import org.springframework.security.core.userdetails.UserDetailsService;
import org.springframework.security.core.userdetails.UsernameNotFoundException;
import org.springframework.stereotype.Service;
import org.springframework.transaction.annotation.Transactional;

@Service
@RequiredArgsConstructor
public class CustomUserDetailsService implements UserDetailsService {

    private final UserRepository userRepository;
    private final AdminRepository adminRepository;
    private final PasswordRepository passwordRepository;

    @Override
    @Transactional
    public UserPrincipal loadUserByUsername(String email) throws UsernameNotFoundException {
        // Check admin first
        Admin admin = adminRepository.findByEmail(email).orElse(null);
        if (admin != null) {
            return UserPrincipal.create(admin);
        }

        // Check regular users
        User user = userRepository.findByEmail(email)
                .orElseThrow(() -> new UsernameNotFoundException("User not found with email: " + email));

        Password password = passwordRepository.findByUserId(user.getId())
                .orElseThrow(() -> new UsernameNotFoundException("Password not found for user: " + email));

        return UserPrincipal.create(user, password.getPasswordHash());
    }

    @Transactional
    public UserPrincipal loadUserById(Long id) {
        // Check admin first
        Admin admin = adminRepository.findById(id).orElse(null);
        if (admin != null) {
            return UserPrincipal.create(admin);
        }

        // Check regular users
        User user = userRepository.findById(id)
                .orElseThrow(() -> new UsernameNotFoundException("User not found with id: " + id));

        Password password = passwordRepository.findByUserId(user.getId())
                .orElseThrow(() -> new UsernameNotFoundException("Password not found for user id: " + id));

        return UserPrincipal.create(user, password.getPasswordHash());
    }
}
