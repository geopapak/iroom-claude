package gr.uowm.iroom.service;

import gr.uowm.iroom.dto.AuthResponse;
import gr.uowm.iroom.dto.LoginRequest;
import gr.uowm.iroom.entity.Admin;
import gr.uowm.iroom.entity.User;
import gr.uowm.iroom.exception.BadRequestException;
import gr.uowm.iroom.repository.AdminRepository;
import gr.uowm.iroom.repository.UserRepository;
import gr.uowm.iroom.security.JwtTokenProvider;
import gr.uowm.iroom.security.UserPrincipal;
import lombok.RequiredArgsConstructor;
import org.springframework.security.authentication.AuthenticationManager;
import org.springframework.security.authentication.UsernamePasswordAuthenticationToken;
import org.springframework.security.core.Authentication;
import org.springframework.security.core.context.SecurityContextHolder;
import org.springframework.stereotype.Service;
import org.springframework.transaction.annotation.Transactional;

@Service
@RequiredArgsConstructor
public class AuthService {

    private final AuthenticationManager authenticationManager;
    private final JwtTokenProvider tokenProvider;
    private final UserRepository userRepository;
    private final AdminRepository adminRepository;

    @Transactional
    public AuthResponse login(LoginRequest loginRequest) {
        Authentication authentication = authenticationManager.authenticate(
                new UsernamePasswordAuthenticationToken(
                        loginRequest.getEmail(),
                        loginRequest.getPassword()
                )
        );

        SecurityContextHolder.getContext().setAuthentication(authentication);
        String jwt = tokenProvider.generateToken(authentication);

        UserPrincipal userPrincipal = (UserPrincipal) authentication.getPrincipal();

        // Get user details
        Admin admin = adminRepository.findByEmail(loginRequest.getEmail()).orElse(null);
        if (admin != null) {
            return AuthResponse.builder()
                    .token(jwt)
                    .type("Bearer")
                    .id(admin.getId())
                    .email(admin.getEmail())
                    .name(admin.getName())
                    .lastName(admin.getLastName())
                    .userType(admin.getUserType())
                    .departmentId(null)
                    .build();
        }

        User user = userRepository.findByEmail(loginRequest.getEmail())
                .orElseThrow(() -> new BadRequestException("User not found"));

        return AuthResponse.builder()
                .token(jwt)
                .type("Bearer")
                .id(user.getId())
                .email(user.getEmail())
                .name(user.getName())
                .lastName(user.getLastName())
                .userType(user.getUserType())
                .departmentId(user.getDepartment().getId())
                .build();
    }

    public UserPrincipal getCurrentUser() {
        Authentication authentication = SecurityContextHolder.getContext().getAuthentication();
        if (authentication != null && authentication.getPrincipal() instanceof UserPrincipal) {
            return (UserPrincipal) authentication.getPrincipal();
        }
        throw new BadRequestException("User not authenticated");
    }
}
